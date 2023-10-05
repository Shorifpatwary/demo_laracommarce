import Box from "@component/Box";
import Card from "@component/Card";
import FlexBox from "@component/FlexBox";
import Grid from "@component/grid/Grid";
import Image from "@component/Image";
import NavLink from "@component/nav-link/NavLink";
import Typography, { H3, SemiSpan, Small } from "@component/Typography";
import NextImage from "next/image";
import Link from "next/link";
import React, { useMemo } from "react";
import { StyledMegaMenu1 } from "./MegaMenuStyle";
import MobileCategoryImageBox from "@component/mobile-category-nav/MobileCategoryImageBox";

interface Image {
  imgUrl: string;
  href: string;
}

interface SubCategory {
  title: string;
  href: string;
}

interface Category {
  title: string;
  href?: string;
  subCategories: SubCategory[];
}

interface MegaMenu {
  categories: Category[];
  rightImage?: Image;
}

interface MegaMenuProps {
  parent_id: number;
  minWidth?: string;
  categoriesState;
}

const MegaMenu3: React.FC<MegaMenuProps> = ({
  parent_id,
  categoriesState,
  minWidth,
}) => {
  // Define the getChild function
  const getChild = (item) => {
    return parent_id == item.parent_id;
  };
  // Use useMemo to memoize the filtered child categories
  const childCategories = useMemo(() => {
    return categoriesState?.filter(getChild);
  }, [categoriesState, parent_id]);

  return childCategories ? (
    <StyledMegaMenu1 className="mega-menu">
      <Card ml="1rem" minWidth={minWidth} boxShadow="regular">
        <FlexBox px="1.25rem" py="0.875rem">
          <Box flex="1 1 0">
            <Grid container spacing={4}>
              {childCategories?.map((item) => {
                return (
                  <Grid item md={3} key={item.id}>
                    <Link href={item.slug}>
                      <a>
                        <MobileCategoryImageBox
                          title={item.name}
                          imgUrl={item.image}
                          icon={item.icon}
                        />
                      </a>
                    </Link>
                  </Grid>
                );
              })}
            </Grid>
          </Box>

          {/* {rightImage && (
            <Link href={rightImage.href}>
              <a>
                <Box position="relative" width="153px" height="100%">
                  <NextImage
                    src={rightImage.imgUrl}
                    layout="fill"
                    objectFit="contain"
                  />
                </Box>
              </a>
            </Link>
          )} */}
        </FlexBox>

        <Link href="/sale-page-2">
          <a>
            <Grid
              container
              spacing={0}
              flexWrap="wrap-reverse"
              containerHeight="100%"
              alignItems="center"
            >
              <Grid item sm={6} xs={12}>
                <Box px="1.25rem">
                  <H3 mb="0.5rem">Big Sale Upto 60% Off</H3>

                  <Typography color="text.muted" mb="0.5rem">
                    Handcrafted from genuine Italian Leather
                  </Typography>

                  <Small
                    fontWeight="700"
                    borderBottom="2px solid"
                    borderColor="primary.main"
                  >
                    SHOP NOW
                  </Small>
                </Box>
              </Grid>
              <Grid item sm={6} xs={12}>
                <FlexBox
                  flexDirection="column"
                  justifyContent="flex-end"
                  height="160px"
                  position="relative"
                >
                  <NextImage
                    layout="fill"
                    objectFit="contain"
                    src="/assets/images/products/paper-bag.png"
                    alt="model"
                  />
                </FlexBox>
              </Grid>
            </Grid>
          </a>
        </Link>
      </Card>
    </StyledMegaMenu1>
  ) : null;
};

MegaMenu3.defaultProps = {
  minWidth: "760px",
};

export default MegaMenu3;

// {item.slug ? (
//   <NavLink className="title-link" href={item.slug}>
//     {item.title}
//   </NavLink>
// ) : (
//   <SemiSpan className="title-link">{item.title}</SemiSpan>
// )}
// {item.subCategories?.map((sub) => (
//   <NavLink className="child-link" href={sub.slug}>
//     {sub.title}
//   </NavLink>
// ))}
