import Box from "@component/Box";
import IconButton from "@component/buttons/IconButton";
import Card from "@component/Card";
import Carousel from "@component/carousel/Carousel";
import FlexBox from "@component/FlexBox";
import Grid from "@component/grid/Grid";
import Icon from "@component/icon/Icon";
import Image from "@component/Image";
import { H2 } from "@component/Typography";
import { bestDiscount } from "@data/apis";
import useWindowSize from "@hook/useWindowSize";
import { ProductInterface } from "interfaces/api-response";
import Link from "next/link";
import React, { useEffect, useState } from "react";
import styled from "styled-components";

const SectionWrapper = styled.div`
  margin-bottom: 3.75rem;

  .left-arrow,
  .right-arrow {
    position: absolute;
    top: -34px;
    right: 0;
  }
  .left-arrow {
    right: 48px;
    left: auto;
  }
  .hinde-on-mobile {
    display: block;
  }
  @media only screen and (max-width: 425px) {
    .hinde-on-mobile {
      display: none;
    }
  }
`;

const Section5: React.FC = () => {
  const totalSlides = 10;
  const [currentSlide, setCurrentSlide] = useState(0);
  const [products, setProducts] = useState<ProductInterface[]>(null);

  const handleSlideChange = (count) => () => {
    if (count < 0) setCurrentSlide(0);
    else if (count > totalSlides - 1) setCurrentSlide(totalSlides - 1);
    else setCurrentSlide(count);
  };

  const [visibleSlides, setVisibleSlides] = useState(productList);
  const width = useWindowSize();

  useEffect(() => {
    if (productList && productList.length > 0) {
      if (width < 500) {
        setVisibleSlides([productList[0]]);
      } else {
        setVisibleSlides(productList);
      }
    }
  }, [width, productList]);

  // useEffect(() => {
  //   fetch(`${bestDiscount.url}`)
  //     .then((response) => response.json())
  //     .then((data) => {
  //       setProducts(data.data);
  //     })
  //     .catch((error) => {
  //       // Handle errors
  //       console.error(error);
  //     });
  // }, []);
  return (
    <SectionWrapper>
      <FlexBox justifyContent="space-between" alignItems="center" mb="1.5rem">
        <H2 fontWeight="bold" lineHeight="1">
          Deal Of The Week
        </H2>

        <FlexBox>
          <IconButton
            variant="contained"
            color="primary"
            mr="0.5rem"
            disabled={currentSlide === 0}
            onClick={handleSlideChange(currentSlide - 1)}
          >
            <Icon variant="small" defaultcolor="currentColor">
              arrow-left
            </Icon>
          </IconButton>
          <IconButton
            variant="contained"
            color="primary"
            disabled={currentSlide === totalSlides - 1}
            onClick={handleSlideChange(currentSlide + 1)}
          >
            <Icon variant="small" defaultcolor="currentColor">
              arrow-right
            </Icon>
          </IconButton>
        </FlexBox>
      </FlexBox>

      <Box mt="-0.25rem" mb="-0.25rem">
        <Carousel
          totalSlides={totalSlides}
          visibleSlides={1}
          arrowButtonColor="primary"
          showDots={true}
          showArrow={false}
          currentSlide={currentSlide}
        >
          {[...new Array(totalSlides)].map((_item, ind) => (
            <Box py="0.25rem" key={ind}>
              <Grid container spacing={6}>
                {visibleSlides?.map((item, ind) => (
                  // <Grid item md={6} xs={12} key={item.id}>
                  //   <Link href="/">
                  //     <a>
                  //       <Card position="relative">
                  //         <Image src={item.thumbnail_link} width="100%" />

                  //         <Box
                  //           position="absolute"
                  //           bg="gray.200"
                  //           fontWeight="600"
                  //           p="6px 12px"
                  //           top="1.25rem"
                  //           left="1.25rem"
                  //           borderRadius={5}
                  //         >
                  //           {item.brand.name}
                  //         </Box>
                  //         <Box
                  //           position="absolute"
                  //           bg="primary.main"
                  //           color="white"
                  //           fontWeight="600"
                  //           p="6px 12px"
                  //           top="1.25rem"
                  //           right="1.25rem"
                  //           borderRadius={5}
                  //         >
                  //           ${item.discount_price} OFF
                  //         </Box>
                  //       </Card>
                  //     </a>
                  //   </Link>
                  // </Grid>
                  <Grid item md={6} xs={12} key={ind}>
                    <Link href="/">
                      <a>
                        <Card position="relative">
                          <Image src={item.imgUrl} width="100%" />

                          <Box
                            position="absolute"
                            bg="gray.200"
                            fontWeight="600"
                            p="6px 12px"
                            top="1.25rem"
                            left="1.25rem"
                            borderRadius={5}
                          >
                            {item.brand}
                          </Box>
                          <Box
                            position="absolute"
                            bg="primary.main"
                            color="white"
                            fontWeight="600"
                            p="6px 12px"
                            top="1.25rem"
                            right="1.25rem"
                            borderRadius={5}
                          >
                            ${item.off} OFF
                          </Box>
                        </Card>
                      </a>
                    </Link>
                  </Grid>
                ))}
              </Grid>
            </Box>
          ))}
        </Carousel>
      </Box>
    </SectionWrapper>
  );
};

const productList = [
  {
    imgUrl: "/assets/images/products/rayban.png",
    brand: "Say Ban Sunglass",
    off: 50,
  },
  {
    imgUrl: "/assets/images/products/nike.png",
    brand: "Yike Shoe Air Max",
    off: 30,
  },
  {
    imgUrl: "/assets/images/products/apple-watch.png",
    brand: "Air Jordan",
    off: 40,
  },
  {
    imgUrl: "/assets/images/products/perfume.png",
    brand: "Perfume",
    off: 20,
  },
];
export default Section5;
