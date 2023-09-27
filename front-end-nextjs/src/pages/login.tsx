import React, { useContext, useEffect } from "react";
import FlexBox from "../components/FlexBox";
import Login from "../components/sessions/Login";
import { useRouter } from "next/router";
import getCookie from "functions/getCookie";
import { AuthContext } from "@context/AuthProvider";

const LoginPage = () => {
  const authContext = useContext(AuthContext);

  const router = useRouter();
  useEffect(() => {
    if (authContext.userCookieState.JWT) {
      console.log("cokie value form login page ", getCookie("JWT"));
      console.log(
        "JWT value form login page ",
        authContext.userCookieState.JWT
      );
      // return;
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
