import Accordion from "@component/accordion/Accordion";
import AccordionHeader from "@component/accordion/AccordionHeader";
import Box from "@component/Box";
import Divider from "@component/Divider";
import Grid from "@component/grid/Grid";
import Header from "@component/header/Header";
import Icon from "@component/icon/Icon";
import MobileCategoryImageBox from "@component/mobile-category-nav/MobileCategoryImageBox";
import { MobileCategoryNavStyle } from "@component/mobile-category-nav/MobileCategoryNavStyle";
import MobileNavigationBar from "@component/mobile-navigation/MobileNavigationBar";
import Typography from "@component/Typography";
import navigations from "@data/navigations";
import useFetch from "@hook/useFetch";
import Link from "next/link";
import React, { Fragment, useEffect, useMemo, useState } from "react";
import { category as categoryApi } from "@data/apis";

const MobileCategoryNav = () => {
  const [category, setCategory] = useState(null);
  const [suggestedList, setSuggestedList] = useState([]);
  const [subCategoryList, setSubCategoryList] = useState([]);
  const [categoriesState, setCategoriesState] = useState([]);

  // Call the useFetch hook to make the GET request
  const { data, error, isLoading, isComplete } = useFetch(
    categoryApi.url,
    categoryApi.method as "GET"
  );

  useEffect(() => {
    // When the component mounts or when data changes, you can handle the response
    if (isComplete) {
      if (error) {
        // Handle the error
        console.error("Error:", error);
      } else {
        // Handle the data
        setCategoriesState(data);
      }
    }
  }, [data, error, isComplete]);

  // Define the getParent function
  const getParent = (item) => {
    return item.parent_id == null;
  };
  // Use useMemo to memoize the filtered parent categories
  const parentCategories = useMemo(() => {
    return categoriesState?.filter(getParent);
  }, [categoriesState]);
  // Define the getChild function
  const getChild = (item) => {
    return category?.id == item.parent_id;
  };
  // Use useMemo to memoize the filtered child categories
  const childCategories = useMemo(() => {
    return categoriesState?.filter(getChild);
  }, [categoriesState, category]);

  // handle category click
  const handleCategoryClick = (cat) => () => {
    setCategory(cat);
  };

  // useEffect(() => {
  //   setSuggestedList(suggestion);
  // }, []);

  return (
    <MobileCategoryNavStyle>
      <Header className="header" />
      <div className="main-category-holder">
        {parentCategories?.map((item) => (
          <Box
            className="main-category-box"
            borderLeft={`${category?.slug === item.slug ? "3" : "0"}px solid`}
            onClick={handleCategoryClick(item)}
            key={item.id}
          >
            <Icon size="28px" mb="0.5rem">
              {item.icon}
            </Icon>
            <Typography
              className="ellipsis"
              textAlign="center"
              fontSize="11px"
              lineHeight="1"
            >
              {item.name}
            </Typography>
          </Box>
        ))}
      </div>
      <Box className="container">
        <Typography fontWeight="600" fontSize="15px" mb="1rem">
          Recommended Categories
        </Typography>
        {/* <Box mb="2rem">
          <Grid container spacing={3}>
            {suggestedList.map((item) => (
              <Grid item lg={1} md={2} sm={3} xs={4} key={item.id}>
                <Link href={item.slug}>
                  <a>
                    <MobileCategoryImageBox {...item} />
                  </a>
                </Link>
              </Grid>
            ))}
          </Grid>
        </Box> */}

        {!(category == null) ? (
          childCategories?.map((item) => (
            <Fragment key={item.id}>
              <Divider />
              <Accordion>
                <AccordionHeader px="0px" py="10px">
                  <Typography fontWeight="600" fontSize="15px">
                    {item.name}
                  </Typography>
                </AccordionHeader>
                <Box mb="2rem" mt="0.5rem">
                  <Grid container spacing={3}>
                    {categoriesState
                      ?.filter((subItem) => {
                        return item.id == subItem.parent_id;
                      })
                      ?.map((childItem) => (
                        <Grid
                          item
                          lg={1}
                          md={2}
                          sm={3}
                          xs={4}
                          key={childItem.id}
                        >
                          <Link href={childItem.slug}>
                            <a>
                              <MobileCategoryImageBox {...childItem} />
                            </a>
                          </Link>
                        </Grid>
                      ))}
                  </Grid>
                </Box>
              </Accordion>
            </Fragment>
          ))
        ) : (
          <Box mb="2rem">
            <Box borderBottom={"1px solid #ddd"} marginBottom={5}>
              <Typography textAlign={"center"} fontSize={25}>
                Select A Category Form Left Sidebar
              </Typography>
            </Box>

            <Grid container spacing={3}>
              {categoriesState?.map((item) => (
                <Grid item lg={1} md={2} sm={3} xs={4} key={item.id}>
                  <Link href={item.slug}>
                    <a>
                      <MobileCategoryImageBox {...item} />
                    </a>
                  </Link>
                </Grid>
              ))}
            </Grid>
          </Box>
        )}
      </Box>
      <MobileNavigationBar />
    </MobileCategoryNavStyle>
  );
};

// const suggestion = [
//   {
//     title: "Belt",
//     href: "/belt",
//     imgUrl: "/assets/images/products/categories/belt.png",
//   },
//   {
//     title: "Hat",
//     href: "/Hat",
//     imgUrl: "/assets/images/products/categories/hat.png",
//   },
//   {
//     title: "Watches",
//     href: "/Watches",
//     imgUrl: "/assets/images/products/categories/watch.png",
//   },
//   {
//     title: "Sunglasses",
//     href: "/Sunglasses",
//     imgUrl: "/assets/images/products/categories/sunglass.png",
//   },
//   {
//     title: "Sneakers",
//     href: "/Sneakers",
//     imgUrl: "/assets/images/products/categories/sneaker.png",
//   },
//   {
//     title: "Sandals",
//     href: "/Sandals",
//     imgUrl: "/assets/images/products/categories/sandal.png",
//   },
//   {
//     title: "Formal",
//     href: "/Formal",
//     imgUrl: "/assets/images/products/categories/shirt.png",
//   },
//   {
//     title: "Casual",
//     href: "/Casual",
//     imgUrl: "/assets/images/products/categories/t-shirt.png",
//   },
// ];

export default React.memo(MobileCategoryNav);
// {
//   item.subCategories?.map((item) => (
//     <Grid item lg={1} md={2} sm={3} xs={4} key={item.id}>
//       <Link href="/product/search/423423">
//         <a>
//           <MobileCategoryImageBox {...item} />
//         </a>
//       </Link>
//     </Grid>
//   ));
// }
