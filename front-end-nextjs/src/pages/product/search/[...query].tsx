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
import { CategoryProvider, useCategory } from "@context/CategoryProvider";
import {
  BrandInterface,
  ProductInterface,
  ProductsWithPagination,
} from "interfaces/api-response";
import { useRouter } from "next/router";
import { productSearch } from "@data/apis";
import { color, textAlign } from "styled-system";

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
  { name: "discount_price", label: "Discout", value: false },
  { name: "today_deal", label: "On Sale", value: false },
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

  // filter changing action
  const width = useWindowSize();
  const isTablet = width < 1025;

  const toggleView = useCallback(
    (v) => () => {
      setView(v);
    },
    []
  );

  const router = useRouter();
  const { query } = router;
  const [search, setSearch] = useState("");
  const [categoryName, setCategoryName] = useState("");
  const [products, setProducts] = useState<ProductsWithPagination>(null);
  const [orderBy, setOrderBy] = useState(sortOptions[0]);
  const [page, setPage] = useState(1);

  const handleSelectChange = (selectedOption) => {
    setOrderBy(selectedOption);
  };

  const { getAllNestedCategories, categories } = useCategory();

  const handleProductFetch = () => {
    let delimiter = "?";
    // Construct the fetch URL based on the presence of search and category
    let fetchURL = productSearch.url;
    if (search) {
      fetchURL += `${delimiter}text=${encodeURIComponent(search)}`;
      delimiter = "&";
    }
    if (categoryName) {
      const category = categories?.filter((item) => item.name === categoryName);
      const nestedCategories = getAllNestedCategories(category[0].id);
      const categoryIds = nestedCategories.map((category) => category.id);
      console.log(categoryIds, "categories ids form inner query ");

      // Send the `category` parameter only if categoryIds is not empty
      if (categoryIds.length > 0) {
        fetchURL += `${delimiter}category=${categoryIds.join(",")}`;
        delimiter = "&";
      }
    }
    // brand
    if (selectedBrands.length > 0) {
      const brandIds = selectedBrands.map((brand) => brand.id);
      fetchURL += `${delimiter}brand=${brandIds.join(",")}`;
      delimiter = "&";
    }
    // product status
    if (productStatus) {
      const activeProductStatus = productStatus.filter(
        (p_status) => p_status.value === true
      );
      if (activeProductStatus.length > 0) {
        const status = activeProductStatus.map((status) => status.name);
        fetchURL += `${delimiter}product_status=${status.join(",")}`;
        delimiter = "&";
      }
    }
    // order by
    if (orderBy) {
      // Include sorting in the URL with ascending/descending
      fetchURL += `${delimiter}order_by=${orderBy.value}&order_direction=${
        orderBy.asc ? "asc" : "desc"
      }`;
    }
    console.log(products, "products form query page");
    // Make your fetch request using the constructed URL
    if (search || categoryName) {
      fetch(fetchURL)
        .then((response) => response.json())
        .then((data) => {
          // Handle the fetched data
          console.log(data.data, "data . data ");

          setProducts(data);
          console.log(products, "products form use effect");
        })
        .catch((error) => {
          // Handle errors
          console.error(error);
        });
    }
  };

  useEffect(() => {
    // Parse the query string to extract search and category values
    if (!!query?.query) {
      const searchParam = new URLSearchParams(query?.query["0"]);

      const searchValue = searchParam.get("search");
      const categoryValue = searchParam.get("category");

      // Update the state with the extracted values
      setSearch(searchValue || "");
      setCategoryName(categoryValue || "");
      setSearch((prevSearch) => searchValue || prevSearch);
      setCategoryName((prevCategory) => categoryValue || prevCategory);
    }
  }, [query]);

  // fetch request when page change
  useEffect(() => {
    fetch(`${productSearch.url}?page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        // Handle the fetched data
        console.log(data.data, "data . data ");

        setProducts(data);
        console.log(products, "products form use effect");
      })
      .catch((error) => {
        // Handle errors
        console.error(error);
      });
  }, [page]);

  useEffect(() => {
    handleProductFetch();
  }, [search, categoryName, orderBy]);

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
                value={orderBy.value}
                onChange={handleSelectChange}
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
                  handleProductFetch={handleProductFetch}
                  setCategoryName={setCategoryName}
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
              handleProductFetch={handleProductFetch}
              setCategoryName={setCategoryName}
            />
          </Hidden>

          <Grid item lg={9} xs={12}>
            {!!products && products.data.length > 0 ? (
              view === "grid" ? (
                <ProductCard1List products={products} setPage={setPage} />
              ) : (
                <ProductCard9List />
              )
            ) : (
              <h2 style={{ textAlign: "center" }}>No products found</h2>
            )}
          </Grid>
        </Grid>
      </Box>
    </CategoryProvider>
  );
};

const sortOptions = [
  { label: "Date (ASC)", value: "created_at", asc: true },
  { label: "Date (DESC)", value: "created_at", asc: false },
  { label: "Stock (ASC)", value: "stock_quantity", asc: true },
  { label: "Stock (DESC)", value: "stock_quantity", asc: false },
  { label: "Price Low to High", value: "selling_price", asc: true },
  { label: "Price High to Low", value: "selling_price", asc: false },
];

ProductSearchResult.layout = NavbarLayout;

export default ProductSearchResult;

// fixing card later. now handling product filter.
