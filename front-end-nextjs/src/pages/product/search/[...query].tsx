import Box from "@component/Box";
import IconButton from "@component/buttons/IconButton";
import Card from "@component/Card";
import FlexBox from "@component/FlexBox";
import Grid from "@component/grid/Grid";
import Hidden from "@component/hidden/Hidden";
import Icon from "@component/icon/Icon";
import NavbarLayout from "@component/layout/NavbarLayout";
import ProductCard1List from "@component/products/ProductCard1List";
import ProductCard9List from "@component/products/ProductCard9List";
import ProductFilterCard from "@component/products/ProductFilterCard";
import Select from "@component/Select";
import Sidenav from "@component/sidenav/Sidenav";
import { H5, Paragraph } from "@component/Typography";
import React, { useCallback, useEffect, useState } from "react";
import useWindowSize from "../../../hooks/useWindowSize";
import { CategoryProvider } from "@context/CategoryProvider";
import { BrandInterface } from "interfaces/api-response";

export type priceRangeType = {
  min: number;
  max: number;
};
export type ProductStatusOption = {
  name: string;
  label: string;
  value: boolean;
};

const productStatusInitialvalue: ProductStatusOption[] = [
  { name: "discount_price", label: "On Sale", value: false },
  { name: "stock_quantity", label: "In Stock", value: false },
  { name: "featured", label: "Featured", value: false },
  { name: "trendy", label: "Trendy", value: false },
];

const ProductSearchResult = () => {
  const [view, setView] = useState<"grid" | "list">("grid");
  const [priceRange, setPriceRange] = useState<priceRangeType>({
    min: null,
    max: null,
  });
  // brand state
  const [selectedBrands, setSelectedBrands] = useState<BrandInterface[]>([]);
  // product status state
  const [productStatus, setProductStatus] = useState<ProductStatusOption[]>(
    productStatusInitialvalue
  );
  // rating state
  const [selectedRatings, setSelectedRatings] = useState<number[]>([]);

  // filter changin action
  useEffect(() => {
    console.log(selectedBrands, "selectedBrands form ");
  }, [priceRange, selectedBrands]);

  const width = useWindowSize();
  const isTablet = width < 1025;

  const toggleView = useCallback(
    (v) => () => {
      setView(v);
    },
    []
  );

  return (
    <CategoryProvider>
      <Box pt="20px">
        <FlexBox
          p="1.25rem"
          flexWrap="wrap"
          justifyContent="space-between"
          alignItems="center"
          mb="55px"
          elevation={5}
          as={Card}
        >
          <div>
            <H5>Searching for “ mobile phone + ”</H5>
            <Paragraph color="text.muted">48 results found</Paragraph>
          </div>
          <FlexBox alignItems="center" flexWrap="wrap">
            <Paragraph color="text.muted" mr="1rem">
              Short by:
            </Paragraph>
            <Box flex="1 1 0" mr="1.75rem" minWidth="150px">
              <Select
                placeholder="Short by"
                defaultValue={sortOptions[0]}
                options={sortOptions}
              />
            </Box>

            <Paragraph color="text.muted" mr="0.5rem">
              View:
            </Paragraph>
            <IconButton size="small" onClick={toggleView("grid")}>
              <Icon
                variant="small"
                defaultcolor="auto"
                color={view === "grid" ? "primary" : "inherit"}
              >
                grid
              </Icon>
            </IconButton>
            <IconButton size="small" onClick={toggleView("list")}>
              <Icon
                variant="small"
                defaultcolor="auto"
                color={view === "list" ? "primary" : "inherit"}
              >
                menu
              </Icon>
            </IconButton>

            {isTablet && (
              <Sidenav
                position="left"
                scroll={true}
                handle={
                  <IconButton size="small">
                    <Icon>options</Icon>
                  </IconButton>
                }
              >
                <ProductFilterCard
                  setPriceRange={setPriceRange}
                  priceRange={priceRange}
                  selectedBrands={selectedBrands}
                  setSelectedBrands={setSelectedBrands}
                  productStatus={productStatus}
                  setProductStatus={setProductStatus}
                  selectedRatings={selectedRatings}
                  setSelectedRatings={setSelectedRatings}
                />
              </Sidenav>
            )}
          </FlexBox>
        </FlexBox>

        <Grid container spacing={6}>
          <Hidden as={Grid} item lg={3} xs={12} down={1024}>
            <ProductFilterCard
              setPriceRange={setPriceRange}
              priceRange={priceRange}
              selectedBrands={selectedBrands}
              setSelectedBrands={setSelectedBrands}
              productStatus={productStatus}
              setProductStatus={setProductStatus}
              selectedRatings={selectedRatings}
              setSelectedRatings={setSelectedRatings}
            />
          </Hidden>

          <Grid item lg={9} xs={12}>
            {view === "grid" ? <ProductCard1List /> : <ProductCard9List />}
          </Grid>
        </Grid>
      </Box>
    </CategoryProvider>
  );
};

const sortOptions = [
  { label: "Relevance", value: "Relevance" },
  { label: "Date", value: "Date" },
  { label: "Price Low to High", value: "Price Low to High" },
  { label: "Price High to Low", value: "Price High to Low" },
];

ProductSearchResult.layout = NavbarLayout;

export default ProductSearchResult;
