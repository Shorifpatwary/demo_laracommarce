import productDatabase from "@data/product-database";
import React from "react";
import FlexBox from "../FlexBox";
import Pagination from "../pagination/Pagination";
import ProductCard9 from "../product-cards/ProductCard9";
import { SemiSpan } from "../Typography";
import { ProductsWithPagination } from "interfaces/api-response";

export interface ProductCard9ListProps {
  products: ProductsWithPagination;
  setPage: React.Dispatch<React.SetStateAction<number>>;
}

const ProductCard9List: React.FC<ProductCard9ListProps> = ({
  products,
  setPage,
}) => {
  return (
    <div>
      {products.data?.map((product) => (
        <ProductCard9 mb="1.25rem" key={product.id} product={product} />
      ))}

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

export default ProductCard9List;
