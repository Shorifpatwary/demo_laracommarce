import productDatabase from "@data/product-database";
import React from "react";
import Box from "../Box";
import Grid from "../grid/Grid";
import ProductCard1 from "../product-cards/ProductCard1";
import { H3 } from "../Typography";
import { ProductInterface } from "interfaces/api-response";

export interface RelatedProductsProps {
  produtcts: ProductInterface[];
}

const RelatedProducts: React.FC<RelatedProductsProps> = ({ produtcts }) => {
  return (
    <Box mb="3.75rem">
      <H3 mb="1.5rem">Realted Products</H3>
      <Grid container spacing={8}>
        {produtcts?.map((product) => (
          <Grid item lg={3} md={4} sm={6} xs={12} key={product.id}>
            <ProductCard1 product={product} hoverEffect />
          </Grid>
        ))}
      </Grid>
    </Box>
  );
};

export default RelatedProducts;
