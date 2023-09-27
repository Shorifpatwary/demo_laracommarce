import React, { useEffect } from "react";
import FlexBox from "../components/FlexBox";
import Signup from "../components/sessions/Signup";
import { useRouter } from "next/router";
import getCookie from "functions/getCookie";

const SignUpPage = () => {
  const router = useRouter();
  useEffect(() => {
    if (getCookie("JWT") !== null) {
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
