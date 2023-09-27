import React, { useContext, useEffect, useState } from "react";
import FlexBox from "../components/FlexBox";
import Signup from "../components/sessions/Signup";
import { useRouter } from "next/router";
import getCookie from "functions/getCookie";
import { AuthContext } from "@context/AuthProvider";

const SignUpPage = () => {
  const { isAuthenticatedUser } = useContext(AuthContext);
  const router = useRouter();

  const [isAuthenticateUser, setIsAuthenticateUser] = useState(false);
  async function checkAuthentication() {
    const isAuthenticated = await isAuthenticatedUser();
    setIsAuthenticateUser(isAuthenticated);
  }
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
      <Signup />
    </FlexBox>
  );
};

export default SignUpPage;
