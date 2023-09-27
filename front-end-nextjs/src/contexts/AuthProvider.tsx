import { createContext, useEffect, useState } from "react";
import { login, register, customer_profile, status } from "@data/apis.json";
import getCookie from "functions/getCookie";
import { useRouter } from "next/router";

type AuthProviderProps = {
  children: React.ReactNode;
};

interface User {
  // customerId: string;
  JWT: string;
}
interface headers {}
interface AuthContextInterface {
  Login: (email: string, password: string) => Promise<any>;
  Logout: () => void;
  Register: (
    name: string,
    email: string,
    password: string,
    confirmPassword: string
  ) => Promise<any>;
  userCookieState: User;
  setUserCookieState: React.Dispatch<React.SetStateAction<User>>;
  // customerId: string,
  setUserCookie: (JWT: string) => void;
  deleteUserCookie: () => void;
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
    // "X-Authorization": process.env.NEXT_PUBLIC_SECRET_KEY_LIVE as string,
    "Content-Type": "application/json",
    // "Content-Type": "multipart/form-data",
    Accept: "application/json",
  };

  const [userCookieState, setUserCookieState] = useState({
    // customerId: "",
    JWT: "",
  });
  // commerce js issue and login token
  const Login = async (email: string, password: string) => {
    try {
      const res = await fetch(login.url, {
        method: login.method,
        body: JSON.stringify({ email, password }),
        headers: headers,
      });
      // if (!res.ok) {
      //   throw new Error("Login failed");
      //   // or extract error message from the response
      // }
      const data = await res.json();
      return data;
    } catch (error) {
      console.error("Login error:", error);
      throw error;
    }
  };

  // commerce js issue and login token
  const Register = async (
    name: string,
    email: string,
    password: string,
    confirmPassword: string
  ) => {
    try {
      const res = await fetch(register.url, {
        method: register.method,
        body: JSON.stringify({ name, email, password, confirmPassword }),
        headers: headers,
      });
      // if (!res.ok) {
      //   throw new Error("Registration failed");
      //   // or extract error message from the response
      // }
      const data = await res.json();
      return data;
    } catch (error) {
      console.log(error);
    }
  };

  // Log out user
  const Logout = () => {
    // Clear the JWT token from cookies
    deleteUserCookie();

    // Redirect the user to the login page or any other appropriate page
    redirectToLogin();
  };

  // SET USER COOKIE FUNCTION customerId: string,
  const setUserCookie = (JWT: string) => {
    // get expires data
    var expires = new Date();
    expires.setDate(expires.getDate() + 30);
    // set cookie
    // add customer id to the cookie
    // document.cookie = `customerId=${customerId}; expires=${expires.toUTCString()};`;
    // add customer JWT to the cookie
    document.cookie = `JWT=${JWT}; expires=${expires.toUTCString()};`;
    // Set user cookie state
    setUserCookieState({
      // customerId: customerId,
      JWT: JWT,
    });
  };

  // DELETE USER COOKIE FUNCTION
  const deleteUserCookie = () => {
    var expires = new Date();
    expires.setDate(expires.getDate() - 30);
    // delete customer id
    // document.cookie = `customerId=""; expires=${expires.toUTCString()};`;
    // delete JWT
    document.cookie = `JWT=""; expires=${expires.toUTCString()};`;
    // SET user cookie state
    setUserCookieState({
      // customerId: "",
      JWT: "",
    });
  };
  // AuthProvider makeAuthenticatedRequest
  const makeAuthenticatedRequest = async (
    url,
    method,
    errorStatus = status.error_unauthorized,
    body = null,
    headers?: headers
  ) => {
    try {
      const jwtToken = getCookie("JWT"); // Get JWT token from cookies using your getCookie function

      if (!jwtToken) {
        // Handle the case where the JWT token is not available (user is not authenticated)
        redirectToLogin();
      }

      const res = await fetch(url, {
        method,
        body: body ? JSON.stringify(body) : null,
        headers: {
          ...headers,
          Authorization: `Bearer ${jwtToken}`, // Include JWT token in headers
        },
      });
      if (!res.ok) {
        console.log(res.status, "response form");
        // errorStatus
        console.log(errorStatus, "error status");
        if (res.status === status.error_unauthorized) {
          // Handle error status code (e.g., 401 Unauthorized)
          redirectToLogin(); // Redirect to the login route
        } else if (res.status === errorStatus) {
          const data = await res.json();
          console.log(data, "data");
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

  const router = useRouter();
  // Function to redirect to the login route
  const redirectToLogin = () => {
    console.log("redirectToLogin function called");
    router.push("/login"); // Replace '/login' with the actual path to your login page
  };

  // SET USER COOKIE ON FIRST RENDER
  useEffect(() => {
    setUserCookieState({
      // customerId: getCookie("customerId") || "",
      JWT: getCookie("JWT") || "",
    });
  }, []);

  return (
    <AuthContext.Provider
      value={{
        Login,
        Logout,
        Register,
        userCookieState,
        setUserCookieState,
        setUserCookie,
        deleteUserCookie,
        makeAuthenticatedRequest,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};
export default AuthProvider;
