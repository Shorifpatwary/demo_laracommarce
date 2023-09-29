import Avatar from "@component/avatar/Avatar";
import Box from "@component/Box";
import Button from "@component/buttons/Button";
import { Card1 } from "@component/Card1";
import FlexBox from "@component/FlexBox";
import Grid from "@component/grid/Grid";
import Hidden from "@component/hidden/Hidden";
import Icon from "@component/icon/Icon";
import DashboardLayout from "@component/layout/CustomerDashboardLayout";
import DashboardPageHeader from "@component/layout/DashboardPageHeader";
import TextField from "@component/text-field/TextField";
import { Formik } from "formik";
import Link from "next/link";
import React, { useContext, useEffect, useState } from "react";
import * as yup from "yup";
import { edit_CP, udpate_CP } from "@data/apis.json";
import { AuthContext } from "@context/AuthProvider";
import { useRouter } from "next/router";
import getCookie from "functions/getCookie";

const ProfileEditor = () => {
  const router = useRouter(); // Initialize the useRouter hook
  const { makeAuthenticatedRequest } = useContext(AuthContext);
  const authContext = useContext(AuthContext);

  const [profileData, setProfileData] = useState(null);

  useEffect(() => {
    // Make an authenticated API request
    authContext
      .makeAuthenticatedRequest(
        edit_CP.url,
        edit_CP.method,
        edit_CP.error_status_code
      )
      .then((data) => {
        setProfileData(data.customer);
      })
      .catch((error) => {
        console.error("Error fetching profile data:", error);
      });
  }, []);

  // CSRF get
  // const [csrfToken, setCsrfToken] = useState("");
  // useEffect(() => {
  //   async function fetchCsrfToken() {
  //     try {
  //       const response = await fetch("http://localhost:8000/api/csrf-endpoint");
  //       const data = await response.json();
  //       setCsrfToken(data.csrf_token);
  //     } catch (error) {
  //       console.error("Error fetching CSRF token:", error);
  //     }
  //   }

  //   fetchCsrfToken();
  // }, []);

  // const handleFormSubmit = async (values) => {
  //   console.log(values, "handle form submit ");
  // };

  // const formSubmitHandler = async (values, formikActions) => {
  //   // Make an authenticated API request

  //   console.log(values);

  //   try {
  //     makeAuthenticatedRequest(
  //       udpate_CP.url,
  //       udpate_CP.method,
  //       udpate_CP.error_status_code,
  //       values
  //     ).then((data) => {
  //       if (data.status === udpate_CP.success_status_code) {
  //         router.push("/profile");
  //       } else if (data && data.errors) {
  //         // Handle server-side validation errors
  //         const serverErrors = data.errors;
  //         // Set the server-side errors to the Formik's errors object
  //         formikActions.setErrors(serverErrors);
  //       }
  //     });
  //   } catch (error) {
  //     // Handle fetch error
  //     console.error("Error updating the data:", error);
  //   }
  // };
  const headers = {
    // "Content-Type": "application/x-www-form-urlencoded",
    "Content-Type": "application/json",
    // "Content-Type": "multipart/form-data",
    Accept: "application/json",
  };
  const formSubmitHandler = async (values, formikActions) => {
    // const form = document.getElementById("form");
    // const formData = new FormData(form);

    // formData.append("name", values.name);
    // formData.append("email", values.email);
    // formData.append("phone", values.phone);
    // formData.append("birth_date", values.birth_date);
    // formData.append("image", values.image);
    // formData.append("_token", values._token);

    const response = await fetch(udpate_CP.url, {
      method: udpate_CP.method,
      headers: {
        ...headers,
        Authorization: `Bearer ${getCookie("JWT")}`,
      },
      body: JSON.stringify(values), // formData, //values, // JSON.stringify(values), new URLSearchParams(formData)
    });

    const data = await response.json();

    if (data.status === udpate_CP.success_status_code) {
      router.push("/profile");
    } else {
      if (data && data.errors) {
        const serverErrors = data.errors;
        // Set the server-side errors to the Formik's errors object
        formikActions.setErrors(serverErrors);
      }
    }
  };

  // Define validation schema
  const checkoutSchema = yup.object().shape({
    name: yup.string().required("Required"),
    email: yup.string().email("Invalid email").required("Required"),
    phone: yup.string().required("Required"),
    birth_date: yup.date().required("Required"),
  });

  return (
    <div>
      <DashboardPageHeader
        iconName="user_filled"
        title="Edit Profile"
        button={
          <Link href="/profile">
            <Button color="primary" bg="primary.light" px="2rem">
              Back to Profile
            </Button>
          </Link>
        }
      />

      <Card1>
        {/* image selection box  */}
        {/* <FlexBox alignItems="flex-end" mb="22px">
          <Avatar src="/assets/images/faces/ralph.png" size={64} />

          <Box ml="-20px" zIndex={1}>
            <label htmlFor="profile_image">
              <Button
                as="span"
                size="small"
                bg="gray.300"
                color="secondary"
                height="auto"
                p="6px"
                borderRadius="50%"
              >
                <Icon>camera</Icon>
              </Button>
            </label>
          </Box>
        </FlexBox> */}

        <Formik
          initialValues={{
            name: profileData?.name || "",
            email: profileData?.email || "",
            phone: profileData?.phone || "",
            birth_date: profileData?.birth_date || "",
            //image: image || null, // Initialize the image field to null
            // _token: profileData?._token || csrfToken,
          }}
          validationSchema={checkoutSchema}
          enableReinitialize={true} // Enable reinitialization
          onSubmit={formSubmitHandler}
        >
          {({
            values,
            errors,
            touched,
            handleChange,
            handleBlur,
            handleSubmit,
            // setFieldValue,
          }) => (
            <form
              onSubmit={handleSubmit}
              //  encType="multipart/form-data"
              id="form"
            >
              {/* <input type="hidden" name="_token" value={csrfToken} /> */}

              <Box mb="30px">
                <Grid container horizontal_spacing={6} vertical_spacing={4}>
                  <Grid item md={6} xs={12}>
                    <TextField
                      name="name"
                      label="First Name"
                      fullwidth
                      onBlur={handleBlur}
                      onChange={handleChange}
                      value={values.name || ""}
                      errorText={touched.name && errors.name}
                    />
                  </Grid>
                  <Grid item md={6} xs={12}>
                    <TextField
                      name="email"
                      type="email"
                      label="Email"
                      fullwidth
                      onBlur={handleBlur}
                      onChange={handleChange}
                      value={values.email || ""}
                      errorText={touched.email && errors.email}
                    />
                  </Grid>
                  <Grid item md={6} xs={12}>
                    <TextField
                      name="phone"
                      label="Phone"
                      fullwidth
                      onBlur={handleBlur}
                      onChange={handleChange}
                      value={values.phone || ""}
                      errorText={touched.phone && errors.phone}
                    />
                  </Grid>
                  <Grid item md={6} xs={12}>
                    <TextField
                      name="birth_date"
                      label="Birth Date"
                      type="date"
                      fullwidth
                      onBlur={handleBlur}
                      onChange={handleChange}
                      value={values.birth_date || ""}
                      errorText={touched.birth_date && errors.birth_date}
                    />
                  </Grid>
                  {/* <Hidden>
                    <Grid item md={6} xs={12}>
                      <TextField
                        type="file"
                        name="image"
                        label="Image"
                        fullwidth
                        onBlur={handleBlur}
                        id="profile_image"
                        onChange={(event) => {
                          const selectedFile = event.target.files[0];
                          setFieldValue("image", selectedFile);
                        }}
                        errorText={touched.image && errors.image}
                      />
                    </Grid>
                  </Hidden> */}
                  {/* Display image field error */}
                  {/* <span>
                    {" "}
                    {touched.image && errors.image && errors.image[0] && (
                      <div style={{ color: "red", marginTop: "10px" }}>
                        {errors.image[0]}
                      </div>
                    )}
                  </span> */}
                </Grid>
              </Box>

              <Button type="submit" variant="contained" color="primary">
                Save Changes
              </Button>
            </form>
          )}
        </Formik>
      </Card1>
    </div>
  );
};

ProfileEditor.layout = DashboardLayout;

export default ProfileEditor;
