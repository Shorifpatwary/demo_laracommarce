import Box from "@component/Box";
import FlexBox from "@component/FlexBox";
import NavbarLayout from "@component/layout/NavbarLayout";
import AvailableShops from "@component/products/AvailableShops";
import FrequentlyBought from "@component/products/FrequentlyBought";
import ProductDescription from "@component/products/ProductDescription";
import ProductIntro from "@component/products/ProductIntro";
import ProductReview from "@component/products/ProductReview";
import RelatedProducts from "@component/products/RelatedProducts";
import { H2, H5 } from "@component/Typography";
import { singleProduct } from "@data/apis";
import useFetch from "@hook/useFetch";
import axios from "axios";
import { ProductInterface } from "interfaces/api-response";
import React, { useState } from "react";

const ProductDetails = ({ product_id }) => {
  // product: ProductInterface,

  const [selectedOption, setSelectedOption] = useState("description");

  const handleOptionClick = (opt) => () => {
    setSelectedOption(opt);
  };
  console.log(product_id, "product_id");

  const { data, error, isLoading, isComplete } = useFetch<ProductInterface>(
    `${singleProduct.url}/${product_id}`
  );
  console.log(data, "data");
  return (
    <div>
      {data ? <ProductIntro product={data} /> : ""}
      <FlexBox
        borderBottom="1px solid"
        borderColor="gray.400"
        mt="80px"
        mb="26px"
      >
        <H5
          className="cursor-pointer"
          mr="25px"
          p="4px 10px"
          color={
            selectedOption === "description" ? "primary.main" : "text.muted"
          }
          borderBottom={selectedOption === "description" && "2px solid"}
          borderColor="primary.main"
          onClick={handleOptionClick("description")}
        >
          Description
        </H5>
        <H5
          className="cursor-pointer"
          p="4px 10px"
          color={selectedOption === "review" ? "primary.main" : "text.muted"}
          onClick={handleOptionClick("review")}
          borderBottom={selectedOption === "review" && "2px solid"}
          borderColor="primary.main"
        >
          Review ({data?.review.length})
        </H5>
      </FlexBox>

      <Box mb="50px">
        {selectedOption === "description" && (
          <ProductDescription description={data?.description} />
        )}
        {selectedOption === "review" && (
          <ProductReview review={data?.review} product_id={product_id} />
        )}
      </Box>

      {/* <FrequentlyBought /> */}

      {/* <AvailableShops /> */}

      {data?.category.products ? (
        <RelatedProducts produtcts={data.category.products} />
      ) : (
        ""
      )}
    </div>
  );
};
export async function getServerSideProps(context) {
  // header
  // const headers = {
  //   Accept: "application/json",
  //   "Content-Type": "application/json",
  // };
  // const axiosInstance = axios.create({
  //   headers: headers,
  // });

  // products request
  const product_id = context.query.id;
  try {
    const response = await axios(`${singleProduct.url}/${product_id}`);
    var product = response.data;

    if (!product) {
      // Handle the case where the product is not found or undefined
      // return {
      //   notFound: true, // Return a 404 page
      // };
    }
  } catch (error) {
    console.error(error);
    // return {
    //   notFound: true, // Return a 404 page
    // };
  }
  return {
    props: {
      // product,
      product_id,
    },
  };
}

ProductDetails.layout = NavbarLayout;

export default ProductDetails;
