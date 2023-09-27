import React, { useContext, useEffect, useState } from "react";
import FlexBox from "../components/FlexBox";
import Login from "../components/sessions/Login";
import { useRouter } from "next/router";
import { AuthContext } from "@context/AuthProvider";

const LoginPage = () => {
  // const authContext = useContext(AuthContext);
  const { isAuthenticatedUser } = useContext(AuthContext);
  const [isAuthenticateUser, setIsAuthenticateUser] = useState(false);

  async function checkAuthentication() {
    const isAuthenticated = await isAuthenticatedUser();
    setIsAuthenticateUser(isAuthenticated);
  }

  const router = useRouter();

  useEffect(() => {
    checkAuthentication();
    if (isAuthenticateUser) {
      router.back();
    }
  });
  return (
    <FlexBox
      flexDirection="column"
      minHeight="100vh"
      alignItems="center"
      justifyContent="center"
    >
      <Login />
    </FlexBox>
  );
};

export default LoginPage;
