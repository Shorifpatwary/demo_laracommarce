import Box from "@component/Box";
import Button from "@component/buttons/Button";
import FlexBox from "@component/FlexBox";
import Icon from "@component/icon/Icon";
import TextField from "@component/text-field/TextField";
import { H3, Paragraph } from "@component/Typography";
import React, { useState } from "react";
import { subscriberCreate } from "@data/apis";
import useFetch from "@hook/useFetch";

const Section9: React.FC = () => {
  const [mail, setMail] = useState("");
  const [message, setMessage] = useState<{
    message: string;
    status: "error" | "success" | null;
  }>({ message: "", status: null });

  const handleSubscribe = async () => {
    // Create a JSON object with the email to send in the request body
    const requestData = {
      email: mail,
    };
    // Check if email is valid
    if (!mail || !mail.includes("@")) {
      setMessage({ message: "Please enter a valid email.", status: "error" });
      return;
    }

    setMessage({ message: "", status: null });

    // Make the API request using the useFetch hook
    // const response = useFetch(subscriberCreate.url, subscriberCreate.method, {
    //   body: { email: mail },
    // });
    fetch(subscriberCreate.url, {
      method: subscriberCreate.method,
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestData),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.data) {
          setMessage({
            message: data.message,
            status: "success",
          });
        } else if (data.errors) {
          setMessage({
            message: data.message,
            status: "error",
          });
        }
      })
      .catch((error) => {
        setMessage({
          message: "Something went wrong!",
          status: "error",
        });
        // Handle errors
        console.error(error, "form error");
      });
  };

  return (
    <Box mb="3.75rem" py="1rem">
      <FlexBox justifyContent="center">
        <Icon size="40px" mb="1.5rem">
          telegram
        </Icon>
      </FlexBox>
      <H3 textAlign="center" fontSize="25px" mb="1rem" lineHeight="1.2">
        Subscribe To Our Newsletter
      </H3>
      <Paragraph
        maxWidth="220px"
        textAlign="center"
        color="text.muted"
        mx="auto"
        mb="1.25rem"
      >
        and receive $20 coupon for the first Shopping
      </Paragraph>

      <Box mx="auto" maxWidth="600px">
        <TextField
          type="email"
          placeholder="Enter Your Mail Here"
          fullwidth
          value={mail}
          onChange={(e) => setMail(e.target.value)}
          endAdornment={
            <Button
              style={{ right: 0 }}
              borderRadius="0px"
              borderBottomRightRadius="8px"
              borderTopRightRadius="8px"
              variant="contained"
              color="primary"
              onClick={handleSubscribe}
            >
              SUBSCRIBE
            </Button>
          }
        />
        {message.status === "success" && (
          <div style={{ color: "green" }}>{message.message}</div>
        )}
        {message.status === "error" && (
          <div style={{ color: "red" }}>{message.message}</div>
        )}
      </Box>
    </Box>
  );
};

export default Section9;
