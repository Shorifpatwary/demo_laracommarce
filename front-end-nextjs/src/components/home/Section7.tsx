import Box from "@component/Box";
import Grid from "@component/grid/Grid";
import ProductCard1 from "@component/product-cards/ProductCard1";
import { H2 } from "@component/Typography";
import { trendingItem } from "@data/apis";
import productDatabase from "@data/product-database";
import { ProductInterface } from "interfaces/api-response";
import React, { useEffect, useState } from "react";

export interface Section7Props {}

const Section7: React.FC<Section7Props> = () => {
  const [products, setProducts] = useState<ProductInterface[]>(null);
  console.log(products, "product form section 7");
  useEffect(() => {
    fetch(`${trendingItem.url}`)
      .then((response) => response.json())
      .then((data) => {
        setProducts(data.data);
      })
      .catch((error) => {
        // Handle errors
        console.error(error);
      });
  }, []);
  return (
    <Box mb="3.75rem">
      <H2 mb="1.5rem">Trending Items</H2>

      <Grid container spacing={6}>
        <Grid item md={4} xs={12}>
          {products ? (
            <ProductCard1 product={products[products.length - 1]} />
          ) : (
            ""
          )}
        </Grid>
        <Grid item md={8} xs={12}>
          <Grid container spacing={6}>
            {products?.map((item) => (
              <Grid item lg={4} sm={6} xs={12} key={item.id}>
                <ProductCard1 product={item} />
              </Grid>
            ))}
          </Grid>
        </Grid>
      </Grid>
    </Box>
  );
};

export default Section7;
