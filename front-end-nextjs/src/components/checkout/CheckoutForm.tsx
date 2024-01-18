import { Formik } from "formik";
import Link from "next/link";
import { useRouter } from "next/router";
import React, { useCallback, useEffect, useState } from "react";
import * as yup from "yup";
import countryList from "../../data/countryList";
import Button from "../buttons/Button";
import { Card1 } from "../Card1";
import CheckBox from "../CheckBox";
import Grid from "../grid/Grid";
import Select from "../Select";
import TextField from "../text-field/TextField";
import Typography from "../Typography";
import { useAppContext } from "@context/app/AppContext";
import { orderInitialState } from "@reducer/orderReducer";

const CheckoutForm = () => {
  const { state, dispatch } = useAppContext();

  const shippingAddress = state.order.shippingAddress;
  const isbillingAddressSame = state.order.isBillingAddressSame;
  const billingAddress = state.order.billingAddress;

  // Function to handle billing address change
  const handleShippingAddress = useCallback(
    (fieldName, value) => {
      // Dispatch an action to set the billing address
      dispatch({
        type: "SET_SHIPPING_ADDRESS",
        payload: {
          // ...shippingAddress, // Preserve existing billing address properties
          ...state.order.shippingAddress,
          [fieldName]: value, // Update the specific field with the new value
        },
      });
    },
    [state.order.shippingAddress]
  );

  // Function to handle billing address change
  const handleIsBillingAddressSame = useCallback(() => {
    dispatch({
      type: "SET_IS_BILLING_ADDRESS_SAME",
      payload: !isbillingAddressSame,
    });
  }, [dispatch, isbillingAddressSame]);

  // Function to handle billing address change
  const handleBillingAddress = useCallback(
    (fieldName, value) => {
      // Dispatch an action to set the billing address
      dispatch({
        type: "SET_BILLING_ADDRESS",
        payload: {
          // ...billingAddress, // Preserve existing billing address properties
          ...state.order.billingAddress,
          [fieldName]: value, // Update the specific field with the new value
        },
      });
    },
    [state.order.billingAddress]
  );

  // const [sameAsShipping, setSameAsShipping] = useState(false);
  const router = useRouter();

  const handleFormSubmit = async (values) => {
    // console.log("Form submitted with values:", values);
    // router.push("/payment");
  };

  // const handleCheckboxChange =
  //   (values: typeof initialValues, setFieldValue) =>
  //   ({ target: { checked } }) => {
  //     setSameAsShipping(checked);
  //     setFieldValue("same_as_shipping", checked);
  //     setFieldValue("billing_name", checked ? values.shipping_name : "");
  //   };

  return (
    <>
      <Formik
        initialValues={state.order}
        // initialValues={orderInitialState}
        validationSchema={checkoutSchema}
        onSubmit={handleFormSubmit}
      >
        {({
          values,
          errors,
          touched,
          handleChange,
          handleBlur,
          handleSubmit,
          setFieldValue,
          isSubmitting,
        }) => (
          <form onSubmit={handleSubmit}>
            <Card1 mb="2rem">
              <Typography fontWeight="600" mb="1rem">
                Shipping Address
              </Typography>

              <Grid container spacing={7}>
                <Grid item sm={6} xs={12}>
                  <TextField
                    name="shipping_name"
                    label="Full Name"
                    fullwidth
                    mb="1rem"
                    onBlur={handleBlur}
                    onChange={(e) => {
                      handleShippingAddress("name", e.target.value);
                      handleChange(e); // Manually call handleChange for Formik to track changes
                    }}
                    value={shippingAddress.name || ""}
                    errorText={touched.shipping_name && errors.shipping_name}
                  />
                  <TextField
                    name="shipping_contact"
                    label="Phone Number"
                    fullwidth
                    mb="1rem"
                    onBlur={handleBlur}
                    // onChange={handleChange}
                    onChange={(e) => {
                      handleShippingAddress("phoneNumber", e.target.value);
                      handleChange(e); // Manually call handleChange for Formik to track changes
                    }}
                    value={shippingAddress.phoneNumber || ""}
                    errorText={
                      touched.shipping_contact && errors.shipping_contact
                    }
                  />
                  <TextField
                    name="shipping_zip"
                    label="Zip Code"
                    type="number"
                    fullwidth
                    mb="1rem"
                    onBlur={handleBlur}
                    // onChange={handleChange}
                    onChange={(e) => {
                      handleShippingAddress("postal_code", e.target.value);
                      handleChange(e); // Manually call handleChange for Formik to track changes
                    }}
                    value={shippingAddress.postal_code || ""}
                    // value={values.shipping_zip || ""}
                    errorText={touched.shipping_zip && errors.shipping_zip}
                  />
                  <TextField
                    name="shipping_address1"
                    label="Address 1"
                    fullwidth
                    onBlur={handleBlur}
                    // onChange={handleChange}
                    onChange={(e) => {
                      handleShippingAddress("address", e.target.value);
                      handleChange(e); // Manually call handleChange for Formik to track changes
                    }}
                    // value={values.shipping_address1 || ""}
                    value={shippingAddress.address || ""}
                    errorText={
                      touched.shipping_address1 && errors.shipping_address1
                    }
                  />
                </Grid>
                {/* <Grid item sm={6} xs={12}> */}
                {/* <TextField
                  name="shipping_email"
                  label="Email Address"
                  type="email"
                  fullwidth
                  mb="1rem"
                  onBlur={handleBlur}
                  onChange={handleChange}
                  value={values.shipping_email || ""}
                  errorText={touched.shipping_email && errors.shipping_email}
                /> */}
                {/* <TextField
                  name="shipping_company"
                  label="Company"
                  fullwidth
                  mb="1rem"
                  onBlur={handleBlur}
                  onChange={handleChange}
                  value={values.shipping_company || ""}
                  errorText={
                    touched.shipping_company && errors.shipping_company
                  }
                /> */}
                {/* <Select
                  mb="1rem"
                  label="Country"
                  options={countryList}
                  value={values.shipping_country || "US"}
                  onChange={(country) => {
                    setFieldValue("shipping_country", country);
                  }}
                  errorText={
                    touched.shipping_country && errors.shipping_country
                  }
                /> */}
                {/* <TextField
                  name="shipping_address2"
                  label="Address 2"
                  fullwidth
                  onBlur={handleBlur}
                  onChange={handleChange}
                  value={values.shipping_address2 || ""}
                  errorText={
                    touched.shipping_address2 && errors.shipping_address2
                  }
                /> */}
                {/* </Grid> */}
              </Grid>
            </Card1>

            <Card1 mb="2rem">
              <Typography fontWeight="600" mb="1rem">
                Billing Address
              </Typography>

              <CheckBox
                label="Same as shipping address"
                // color={isbillingAddressSame ? "secondary" : "primary"}
                color="secondary"
                mb={isbillingAddressSame ? "" : "5rem"}
                onChange={handleIsBillingAddressSame}
              />

              {!isbillingAddressSame && (
                <Grid container spacing={7}>
                  <Grid item sm={6} xs={12}>
                    <TextField
                      name="billing_name"
                      label="Full Name"
                      fullwidth
                      mb="1rem"
                      onBlur={handleBlur}
                      onChange={(e) => {
                        handleBillingAddress("name", e.target.value);
                        handleChange(e);
                      }}
                      value={billingAddress.name || ""}
                      errorText={touched.billing_name && errors.billing_name}
                    />
                    <TextField
                      name="billing_contact"
                      label="Phone Number"
                      fullwidth
                      mb="1rem"
                      onBlur={handleBlur}
                      // onChange={handleChange}
                      onChange={(e) => {
                        handleBillingAddress("phoneNumber", e.target.value);
                        handleChange(e);
                      }}
                      value={billingAddress.phoneNumber || ""}
                      errorText={
                        touched.billing_contact && errors.billing_contact
                      }
                    />
                    <TextField
                      name="billing_zip"
                      label="Zip Code"
                      type="number"
                      fullwidth
                      mb="1rem"
                      onBlur={handleBlur}
                      // onChange={handleChange}
                      onChange={(e) => {
                        handleBillingAddress("postal_code", e.target.value);
                        handleChange(e);
                      }}
                      // value={values.billing_zip || ""}
                      value={billingAddress.postal_code || ""}
                      errorText={touched.billing_zip && errors.billing_zip}
                    />
                    <TextField
                      name="billing_address1"
                      label="Address 1"
                      fullwidth
                      onBlur={handleBlur}
                      // onChange={handleChange}
                      onChange={(e) => {
                        handleBillingAddress("address", e.target.value);
                        handleChange(e);
                      }}
                      // value={values.billing_address1 || ""}
                      value={billingAddress.address || ""}
                      errorText={
                        touched.billing_address1 && errors.billing_address1
                      }
                    />
                  </Grid>
                  {/* <Grid item sm={6} xs={12}> */}
                  {/* <TextField
                    name="billing_email"
                    label="Email Address"
                    type="email"
                    fullwidth
                    mb="1rem"
                    onBlur={handleBlur}
                    onChange={handleChange}
                    value={values.billing_email || ""}
                    errorText={touched.billing_email && errors.billing_email}
                  /> */}
                  {/* <TextField
                    name="billing_company"
                    label="Company"
                    fullwidth
                    mb="1rem"
                    onBlur={handleBlur}
                    onChange={handleChange}
                    value={values.billing_company || ""}
                    errorText={
                      touched.billing_company && errors.billing_company
                    }
                  /> */}
                  {/* <Select
                    mb="1rem"
                    label="Country"
                    options={countryList}
                    errorText={
                      touched.billing_country && errors.billing_country
                    }
                  /> */}
                  {/* <TextField
                    name="billing_address2"
                    label="Address 2"
                    fullwidth
                    onBlur={handleBlur}
                    onChange={handleChange}
                    value={values.billing_address2 || ""}
                    errorText={
                      touched.billing_address2 && errors.billing_address2
                    }
                  /> */}
                  {/* </Grid> */}
                </Grid>
              )}
            </Card1>

            <Grid container spacing={7}>
              <Grid item sm={6} xs={12}>
                <Link href="/cart">
                  <Button
                    variant="outlined"
                    color="primary"
                    type="button"
                    fullwidth
                  >
                    Back to Cart
                  </Button>
                </Link>
              </Grid>
              <Grid item sm={6} xs={12}>
                <Link href="/payment">
                  <Button
                    variant="contained"
                    color="primary"
                    type="submit"
                    fullwidth
                  >
                    Proceed to Payment
                  </Button>
                </Link>
              </Grid>
            </Grid>
          </form>
        )}
      </Formik>
    </>
  );
};

const initialValues = {
  // postal_code : orderInitialState.billingAddress.postal_code,
  shipping_name: "",
  // shipping_email: "",
  shipping_contact: "",
  // shipping_company: "",
  shipping_zip: orderInitialState.shippingAddress.postal_code,
  // shipping_country: "",
  shipping_address1: orderInitialState.shippingAddress.address,
  // shipping_address2: "",
  billing_name: "",
  // billing_email: "",
  billing_contact: "",
  // billing_company: "",
  billing_zip: orderInitialState.billingAddress.postal_code,
  // billing_country: "",
  billing_address1: orderInitialState.billingAddress.address,
  // billing_address2: "",
};

const checkoutSchema = yup.object().shape({
  shipping_name: yup.string().required("required"),
  // shipping_email: yup.string().email("invalid email").required("required"),
  shipping_contact: yup.string().required("required"),
  shipping_zip: yup.string().required("required"),
  // shipping_country: yup.object().required("required"),
  shipping_address1: yup.string().required("required"),
  billing_name: yup.string().required("required"),
  // billing_email: yup.string().required("required"),
  billing_contact: yup.string().required("required"),
  billing_zip: yup.string().required("required"),
  // billing_country: yup.string().required("required"),
  billing_address1: yup.string().required("required"),
});

export default CheckoutForm;
