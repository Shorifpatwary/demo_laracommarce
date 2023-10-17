import React, { useContext, useEffect, useState } from "react";
import Box from "../Box";
import Button from "../buttons/Button";
import FlexBox from "../FlexBox";
import Rating from "../rating/Rating";
import TextArea from "../textarea/TextArea";
import { H2, H5, Small } from "../Typography";
import ProductComment from "./ProductComment";
import { useFormik } from "formik";
import * as yup from "yup";
import useFetch from "@hook/useFetch";
import { createProductReview, getProductReview } from "@data/apis";
import { productReviewInterface } from "interfaces/api-response";
import { AuthContext } from "@context/AuthProvider";
import { useRouter } from "next/router";
import Hidden from "@component/hidden/Hidden";

export interface ProductReviewProps {
  review: productReviewInterface[];
  product_id: number;
}

const ProductReview: React.FC<ProductReviewProps> = ({
  review,
  product_id,
}) => {
  const { makeAuthenticatedRequest, isAuthenticatedUser } =
    useContext(AuthContext);

  const handleFormSubmit = async (values, formikActions) => {
    setFieldValue("product_id", product_id);

    try {
      const data = await makeAuthenticatedRequest(
        createProductReview.url,
        createProductReview.method,
        createProductReview.error_status_code,
        values
      );

      if (data && data.errors) {
        console.log(data.status, "data status ");
        const serverErrors = data.errors;
        // Set the server-side errors to the Formik's errors object
        formikActions.setErrors(serverErrors);
      } else {
        formikActions.resetForm();
      }
    } catch (error) {
      console.log(error, "make auth");
    }
  };

  const initialValues = {
    rating: "",
    body: "",
    product_id: product_id,
  };

  const {
    values,
    errors,
    touched,
    dirty,
    isValid,
    handleChange,
    handleBlur,
    handleSubmit,
    setFieldValue,
  } = useFormik({
    initialValues: initialValues,
    validationSchema: reviewSchema,
    onSubmit: handleFormSubmit,
  });

  return (
    <Box>
      {review?.map((item) => (
        <ProductComment review={item} key={item.id} />
      ))}

      <H2 fontWeight="600" mt="55px" mb="20">
        Write a Review for this product
      </H2>

      <form onSubmit={handleSubmit}>
        <Box mb="20px">
          <FlexBox mb="12px">
            <H5 color="gray.700" mr="6px">
              Your Rating
            </H5>
            <H5 color="error.main">*</H5>
          </FlexBox>

          <Rating
            outof={5}
            color="warn"
            size="medium"
            readonly={false}
            value={values.rating || 0}
            onChange={(value) => setFieldValue("rating", value)}
          />
        </Box>

        <Box mb="24px">
          <FlexBox mb="12px">
            <H5 color="gray.700" mr="6px">
              Your Review
            </H5>
            <H5 color="error.main">*</H5>
          </FlexBox>

          <TextArea
            name="body"
            placeholder="Write a review here..."
            fullwidth
            rows={8}
            onBlur={handleBlur}
            onChange={handleChange}
            value={values.body || ""}
            errorText={touched.body && errors.body}
          />
          <Hidden>
            {/* <TextArea name="product_id" className="hidden" value={productID} /> */}
          </Hidden>

          {errors ? (
            <Small
              fontWeight="600"
              fontSize="12px"
              color="red"
              textAlign="center"
              mb="2.25rem"
              mt="2rem"
            >
              {errors?.product_id || ""}
            </Small>
          ) : (
            ""
          )}
        </Box>

        <Button
          variant="contained"
          color="primary"
          size="small"
          type="submit"
          disabled={!(dirty && isValid)}
        >
          Submit
        </Button>
      </form>
    </Box>
  );
};

const reviewSchema = yup.object().shape({
  rating: yup.number().required("required"),
  body: yup.string().required("required").min(5),
});

export default React.memo(ProductReview);
