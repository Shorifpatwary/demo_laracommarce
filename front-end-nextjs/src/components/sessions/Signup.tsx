import { useFormik } from "formik";
import Link from "next/link";
import React, { useContext, useEffect, useState } from "react";
import * as yup from "yup";
import Box from "../Box";
import Button from "../buttons/Button";
import IconButton from "../buttons/IconButton";
import CheckBox from "../CheckBox";
import Divider from "../Divider";
import FlexBox from "../FlexBox";
import Icon from "../icon/Icon";
import TextField from "../text-field/TextField";
import { H3, H5, H6, SemiSpan, Small, Span } from "../Typography";
import { StyledSessionCard } from "./SessionStyle";
import { register } from "@data/apis.json";
import { AuthContext } from "@context/AuthProvider";
import { useRouter } from "next/router";

const Signup: React.FC = () => {
  const [passwordVisibility, setPasswordVisibility] = useState(false);

  const togglePasswordVisibility = () => {
    setPasswordVisibility((visible) => !visible);
  };
  // request response
  const [response, setResponse] = useState<{ message; status }>(null);
  const router = useRouter();
  const authContext = useContext(AuthContext);

  const handleFormSubmit = async (formValues, formikActions) => {
    const data = await authContext.Register(
      // formValues.name,
      // formValues.email,
      // formValues.password,
      // formValues.password_confirmation
      formValues
    );
    setResponse(data); // REMOVE
    if (data.status === register.success_status_code) {
      // set cookie
      authContext.setUserCookie(data.token);
      // Redirect or handle successful login as needed
      router.push("/profile");
    } else {
      // Handle server-side validation errors
      // response.data.errors should contain the validation errors from your API
      if (data && data.errors) {
        const serverErrors = data.errors;
        // Set the server-side errors to the Formik's errors object
        formikActions.setErrors(serverErrors);
      }
    }
    // router.push("/profile");
  };

  const { values, errors, touched, handleBlur, handleChange, handleSubmit } =
    useFormik({
      onSubmit: handleFormSubmit,
      initialValues,
      validationSchema: formSchema,
    });

  return (
    <StyledSessionCard mx="auto" my="2rem" boxShadow="large">
      <form className="content" onSubmit={handleSubmit}>
        <H3 textAlign="center" mb="0.5rem">
          Create Your Account
        </H3>
        <H5
          fontWeight="600"
          fontSize="12px"
          color="gray.800"
          textAlign="center"
          mb="2.25rem"
        >
          Please fill all forms to continued
        </H5>

        <TextField
          mb="0.75rem"
          name="name"
          label="Full Name"
          placeholder="Ralph Adwards"
          fullwidth
          onBlur={handleBlur}
          onChange={handleChange}
          value={values.name || ""}
          errorText={touched.name && errors.name}
        />
        <TextField
          mb="0.75rem"
          name="email"
          placeholder="exmple@mail.com"
          label="Email or Phone Number"
          type="email"
          fullwidth
          onBlur={handleBlur}
          onChange={handleChange}
          value={values.email || ""}
          errorText={touched.email && errors.email}
        />
        <TextField
          mb="0.75rem"
          name="password"
          placeholder="*********"
          type={passwordVisibility ? "text" : "password"}
          label="Password"
          fullwidth
          endAdornment={
            <IconButton
              size="small"
              type="button"
              p="0.25rem"
              mr="0.25rem"
              color={passwordVisibility ? "gray.700" : "gray.600"}
              onClick={togglePasswordVisibility}
            >
              <Icon variant="small" defaultcolor="currentColor">
                {passwordVisibility ? "eye-alt" : "eye"}
              </Icon>
            </IconButton>
          }
          onBlur={handleBlur}
          onChange={handleChange}
          value={values.password || ""}
          errorText={touched.password && errors.password}
        />
        <TextField
          mb="1rem"
          name="password_confirmation"
          placeholder="*********"
          type={passwordVisibility ? "text" : "password"}
          label="Confirm Password"
          fullwidth
          endAdornment={
            <IconButton
              size="small"
              type="button"
              p="0.25rem"
              mr="0.25rem"
              color={passwordVisibility ? "gray.700" : "gray.600"}
              onClick={togglePasswordVisibility}
            >
              <Icon variant="small" defaultcolor="currentColor">
                {passwordVisibility ? "eye-alt" : "eye"}
              </Icon>
            </IconButton>
          }
          onBlur={handleBlur}
          onChange={handleChange}
          value={values.password_confirmation || ""}
          errorText={
            touched.password_confirmation && errors.password_confirmation
          }
        />
        {/* phone */}
        <TextField
          my="1rem"
          name="phone"
          label="Phone"
          placeholder="+991 23423 234234"
          fullwidth
          onBlur={handleBlur}
          onChange={handleChange}
          value={values.phone || ""}
          errorText={touched.phone && errors.phone}
        />
        {/* birth date */}
        <TextField
          my="1rem"
          name="birth_date"
          label="Birth Date"
          type="date"
          fullwidth
          onBlur={handleBlur}
          onChange={handleChange}
          value={values.birth_date || ""}
          errorText={touched.birth_date && errors.birth_date}
        />

        <CheckBox
          my={"1.75rem"}
          name="agreement"
          color="secondary"
          checked={values.agreement}
          onChange={handleChange}
          label={
            <FlexBox>
              <SemiSpan>By signing up, you agree to</SemiSpan>
              <a href="/" target="_blank" rel="noreferrer noopener">
                <H6 ml="0.5rem" borderBottom="1px solid" borderColor="gray.900">
                  Terms & Condtion
                </H6>
              </a>
            </FlexBox>
          }
        />
        {/* show request response error message  */}
        {
          response?.status !== register.success_status_code ? (
            <H5
              fontWeight="600"
              fontSize="14px"
              color="red"
              textAlign="center"
              mb="2.25rem"
              mt="2rem"
            >
              {response?.message || ""}
            </H5>
          ) : (
            ""
          ) // Render an empty string if the condition is not met
        }
        <Button
          mb="1.65rem"
          variant="contained"
          color="primary"
          type="submit"
          fullwidth
        >
          Create Account
        </Button>

        <Box mb="1rem">
          <Divider width="200px" mx="auto" />
          <FlexBox justifyContent="center" mt="-14px">
            <Span color="text.muted" bg="body.paper" px="1rem">
              on
            </Span>
          </FlexBox>
        </Box>

        <FlexBox
          justifyContent="center"
          alignItems="center"
          bg="#3B5998"
          borderRadius={5}
          height="40px"
          color="white"
          cursor="pointer"
          mb="0.75rem"
        >
          <Icon variant="small" defaultcolor="auto" mr="0.5rem">
            facebook-filled-white
          </Icon>
          <Small fontWeight="600">Continue with Facebook</Small>
        </FlexBox>

        <FlexBox
          justifyContent="center"
          alignItems="center"
          bg="#4285F4"
          borderRadius={5}
          height="40px"
          color="white"
          cursor="pointer"
          mb="1.25rem"
        >
          <Icon variant="small" defaultcolor="auto" mr="0.5rem">
            google-1
          </Icon>
          <Small fontWeight="600">Continue with Google</Small>
        </FlexBox>
      </form>
      <FlexBox justifyContent="center" bg="gray.200" py="19px">
        <SemiSpan>Already have account?</SemiSpan>
        <Link href="/login">
          <a>
            <H6 ml="0.5rem" borderBottom="1px solid" borderColor="gray.900">
              Log in
            </H6>
          </a>
        </Link>
      </FlexBox>
    </StyledSessionCard>
  );
};

const initialValues = {
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  phone: "",
  birth_date: "",
  agreement: false,
};

const formSchema = yup.object().shape({
  name: yup
    .string()
    .min(5, "${path} must be at least 5 characters")
    .max(255, "${path} must not exceed 255 characters")
    .required("${path} is required"),
  email: yup.string().email("invalid email").required("${path} is required"),
  password: yup
    .string()
    .min(6, "${path} must be at least 6 characters")
    .max(50, "${path} must not exceed 50 characters")
    .required("${path} is required"),
  password_confirmation: yup
    .string()
    .oneOf([yup.ref("password"), null], "Passwords must match")
    .required("Please re-type ${path}"),
  phone: yup
    .string()
    .min(6, "${path} must be at least 6 characters")
    .max(50, "${path} must not exceed 50 characters"),
  birth_date: yup.date(),
  agreement: yup
    .bool()
    .test(
      "agreement",
      "You have to agree with our Terms and Conditions!",
      (value) => value === true
    )
    .required("You have to agree with our Terms and Conditions!"),
});

export default Signup;
