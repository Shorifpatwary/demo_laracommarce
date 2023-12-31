import Card from "@component/Card";
import { Span } from "@component/Typography";
import { debounce } from "lodash";
import Link from "next/link";
import React, { useCallback, useEffect, useState } from "react";
import Box from "../Box";
import FlexBox from "../FlexBox";
import Icon from "../icon/Icon";
import Menu from "../Menu";
import MenuItem from "../MenuItem";
import TextField from "../text-field/TextField";
import StyledSearchBox from "./SearchBoxStyle";
import { useCategory } from "@context/CategoryProvider";
import { useRouter } from "next/router";

export interface SearchBoxProps {}

const SearchBox: React.FC<SearchBoxProps> = () => {
  const router = useRouter();
  console.log(router, "router ");

  const [category, setCategory] = useState({
    id: null,
    name: "All Categories",
  });
  const [query, setQuery] = useState<string>("");
  const [resultList, setResultList] = useState([]);

  const { parentCategories } = useCategory();

  const handleCategoryChange = (cat) => () => {
    setCategory(cat);
  };

  const handleKeyPress = () => {
    if (query.trim() === "") {
      return;
    }
    if (category.name === "All Categories" || category.id === null) {
      // router.push(`/product/search/search=${encodeURIComponent(query)}`);
      router.push(`/product/search/search=${encodeURIComponent(query)}`);
    } else {
      router.push(
        `/product/search/search=${encodeURIComponent(query)}&category=${
          category.name
        }`

        // `/product/search/search=${encodeURIComponent(query)}/category/${
        //   category.name
        // }`
      );
    }
  };

  // const search = debounce((e) => {
  //   const value = e.target?.value;

  //   // if (!value) setResultList([]);
  //   setQuery((prev) => prev + value);
  //   // else setResultList(dummySearchResult);
  // }, 200);

  // const handleSearch = useCallback((event) => {
  //   event.persist();
  //   search(event);
  // }, []);

  const handleDocumentClick = () => {
    // if (resultList !== []) {
    //   setResultList([]);
    // }
  };

  useEffect(() => {
    window.addEventListener("click", handleDocumentClick);
    return () => {
      window.removeEventListener("click", handleDocumentClick);
    };
  }, []);

  return (
    <Box position="relative" flex="1 1 0" maxWidth="670px" mx="auto">
      <StyledSearchBox>
        <Icon className="search-icon" size="18px">
          search
        </Icon>
        <TextField
          className="search-field"
          placeholder="Search and hit enter..."
          fullwidth
          value={query}
          onChange={(e) => setQuery(e.target.value)}
          onKeyDown={(e) => {
            if (e.key === "Enter") {
              handleKeyPress();
            }
          }}
        />
        <Menu
          className="category-dropdown"
          direction="right"
          handler={
            <FlexBox className="dropdown-handler" alignItems="center">
              <span>{category.name}</span>
              <Icon variant="small">chevron-down</Icon>
            </FlexBox>
          }
        >
          {parentCategories?.map((item) => (
            <MenuItem key={item.id} onClick={handleCategoryChange(item)}>
              {item.name}
            </MenuItem>
          ))}
        </Menu>
        {/* <Box className="menu-button" ml="14px" cursor="pointer">
          <Icon color="primary">menu</Icon>
        </Box> */}
      </StyledSearchBox>

      {!!resultList.length && (
        <Card
          position="absolute"
          top="100%"
          py="0.5rem"
          width="100%"
          boxShadow="large"
          zIndex={99}
        >
          {resultList.map((item) => (
            <Link href={`/product/search/search?q=${item}`} key={item}>
              <MenuItem key={item}>
                <Span fontSize="14px">{item}</Span>
              </MenuItem>
            </Link>
          ))}
        </Card>
      )}
    </Box>
  );
};

const categories = [
  "All Categories",
  "Car",
  "Clothes",
  "Electronics",
  "Laptop",
  "Desktop",
  "Camera",
  "Toys",
];

const dummySearchResult = [
  "Macbook Air 13",
  "Ksus K555LA",
  "Acer Aspire X453",
  "iPad Mini 3",
  "something more ",
];

export default React.memo(SearchBox);
