import productDatabase from "@data/product-database";
import React, { useEffect } from "react";
import FlexBox from "../FlexBox";
import Grid from "../grid/Grid";
import Pagination from "../pagination/Pagination";
import ProductCard1 from "../product-cards/ProductCard1";
import { SemiSpan } from "../Typography";
import { ProductsWithPagination } from "interfaces/api-response";

export interface ProductCard1ListProps {
  products: ProductsWithPagination;
  setPage: React.Dispatch<React.SetStateAction<number>>;
}

const ProductCard1List: React.FC<ProductCard1ListProps> = ({
  products,
  setPage,
}) => {
  return (
    <div>
      <Grid container spacing={6}>
        {/* {!!products.data?.length ? ( */}
        {products.data?.map((product) => (
          <Grid item lg={4} sm={6} xs={12} key={product.id}>
            <ProductCard1 product={product} />
          </Grid>
        ))}
        {/* ) : (
          <span>No Product</span>
        )} */}
      </Grid>

      <FlexBox
        flexWrap="wrap"
        justifyContent="space-between"
        alignItems="center"
        mt="32px"
      >
        <SemiSpan>
          Showing {products.meta.from} - {products.meta.to} of{" "}
          {products.meta.total} Products
          <span> </span>
        </SemiSpan>
        <Pagination pageCount={products.meta.last_page} setPage={setPage} />
      </FlexBox>
    </div>
  );
};

export default ProductCard1List;
