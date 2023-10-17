import { createContext, useEffect, useState } from "react";
import {
  login,
  register,
  status,
  checkTokenValidity,
  logout,
} from "@data/apis";
import Cookies from "js-cookie";
import { useRouter } from "next/router";

type AuthProviderProps = {
  children: React.ReactNode;
};

interface headers {}
interface AuthContextInterface {
  Login: (email: string, password: string) => Promise<any>;
  Logout: () => void;
  Register: (values: {}) => Promise<any>;

  setUserCookie: (JWT: string) => void;
  deleteUserCookie: () => void;
  isAuthenticatedUser: () => Promise<boolean>;
  makeAuthenticatedRequest: (
    url: string,
    method: string,
    errorStatus?: number,
    body?: Record<string, any> | null,
    headers?: headers
  ) => Promise<any>;
}
export const AuthContext = createContext<AuthContextInterface>(
  {} as AuthContextInterface
);

const AuthProvider: React.FC<AuthProviderProps> = ({ children }) => {
  // request header
  const headers = {
    "Content-Type": "application/json",

    Accept: "application/json",
  };
  const router = useRouter();

  // LOGIN
  const Login = async (email: string, password: string) => {
    try {
      const res = await fetch(login.url, {
        method: login.method,
        body: JSON.stringify({ email, password }),
        headers: headers,
      });
      const data = await res.json();
      return data;
      // this is wrong
    } catch (error) {
      console.error("Login error:", error);
    }
  };

  //  REGISTER
  const Register = async (values) => {
    try {
      const res = await fetch(register.url, {
        method: register.method,
        body: JSON.stringify(values),
        headers: headers,
      });
      const data = await res.json();
      return data;
      // this is wrong
    } catch (error) {
      console.log(error);
    }
  };
  // LOG-OUT
  const Logout = async () => {
    try {
      const jwtToken = Cookies.get("JWT", { path: "/" });
      const res = await fetch(logout.url, {
        method: logout.method,
        headers: {
          ...headers,
          Authorization: `Bearer ${jwtToken}`,
        },
      });
      if (res.ok) {
        // Clear the JWT token from cookies
        deleteUserCookie();
        // Redirect the user to the login page or any other appropriate page
        redirectToLogin();
      }
      const data = await res.json();

      // return data;
    } catch (error) {
      console.log(error);
    }
  };

  // SET USER COOKIE FUNCTION customerId: string,
  const setUserCookie = (JWT: string) => {
    // Set the JWT as a cookie with an expiration date
    if (!!Cookies.get("JWT", { path: "/" })) {
      deleteUserCookie();
    }

    Cookies.set("JWT", JWT, { expires: 30, path: "/" });
  };

  // DELETE USER COOKIE FUNCTION
  const deleteUserCookie = () => {
    Cookies.remove("JWT", { path: "/" });
  };
  //  makeAuthenticatedRequest
  const makeAuthenticatedRequest = async (
    url,
    method,
    errorStatus = status.error_unauthorized,
    body = null,
    headers?: headers
  ) => {
    try {
      const jwtToken = Cookies.get("JWT", { path: "/" });

      if (!jwtToken) {
        redirectToLogin();
      }
      const requestHeaders = {
        ...headers,
        Authorization: `Bearer ${jwtToken}`,
      };

      if (body) {
        requestHeaders["Content-Type"] = "application/json"; // Set the content type for JSON
      }
      const res = await fetch(url, {
        method,
        body: body ? JSON.stringify(body) : null,
        headers: requestHeaders,
      });
      if (!res.ok) {
        // errorStatus
        if (res.status === status.error_unauthorized) {
          // Handle error status code (e.g., 401 Unauthorized)
          redirectToLogin(); // Redirect to the login route
        } else if (res.status === errorStatus) {
          const data = await res.json();
          return data;
        } else {
          throw new Error("Request failed");
        }
      }
      const data = await res.json();

      return data;
    } catch (error) {
      console.error("API request error:", error);
      throw error;
    }
  };

  // Function to check if the user is authenticated
  const isAuthenticatedUser = async () => {
    try {
      const jwtToken = Cookies.get("JWT", { path: "/" });

      if (!jwtToken) {
        // If JWT token is not available, the user is not authenticated
        return false;
      }

      // Make a request to the server to verify authentication
      const res = await fetch(checkTokenValidity.url, {
        method: checkTokenValidity.method,
        headers: {
          Authorization: `Bearer ${jwtToken}`,
        },
      });

      if (res.ok && res.status === 200) {
        // If the server responds with a success status, the user is authenticated
        return true;
      } else {
        // If the server responds with an error status, the user is not authenticated
        deleteUserCookie();
        return false;
      }
    } catch (error) {
      console.error("Error checking authentication:", error);
      return false;
    }
  };

  // Function to redirect to the login route
  const redirectToLogin = () => {
    router.push("/login"); // Replace '/login' with the actual path to your login page
  };

  // SET USER COOKIE ON FIRST RENDER
  // useEffect(() => {
  //   setUserCookieState({
  //     // customerId: getCookie("customerId") || "",
  //     JWT: getCookie("JWT") || "",
  //   });
  // }, []);

  return (
    <AuthContext.Provider
      value={{
        Login,
        Logout,
        Register,
        // userCookieState,
        // setUserCookieState,
        setUserCookie,
        deleteUserCookie,
        makeAuthenticatedRequest,
        isAuthenticatedUser,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};
export default AuthProvider;
