import Box from "@component/Box";
import React, { useEffect, useState } from "react";
import useWindowSize from "../../hooks/useWindowSize";
import Carousel from "../carousel/Carousel";
import CategorySectionCreator from "../CategorySectionCreator";
import ProductCard1 from "../product-cards/ProductCard1";
import { todayDeal } from "@data/apis";
import { ProductInterface } from "interfaces/api-response";

const Section2: React.FC = () => {
  const [visibleSlides, setVisibleSlides] = useState(4);
  const [products, setProducts] = useState<ProductInterface[]>(null);
  const width = useWindowSize();

  useEffect(() => {
    if (width < 500) setVisibleSlides(1);
    else if (width < 650) setVisibleSlides(2);
    else if (width < 950) setVisibleSlides(3);
    else setVisibleSlides(4);
  }, [width]);

  useEffect(() => {
    fetch(`${todayDeal.url}`)
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
    <CategorySectionCreator
      iconName="light"
      title="Flash Deals"
      seeMoreLink="#"
    >
      <Box mt="-0.25rem" mb="-0.25rem">
        <Carousel totalSlides={10} visibleSlides={visibleSlides}>
          {products?.map((item, ind) => (
            <Box py="0.25rem" key={ind}>
              <ProductCard1 product={item} key={ind} />
            </Box>
          ))}
        </Carousel>
      </Box>
    </CategorySectionCreator>
  );
};

const productList = [
  {
    imgUrl: "/assets/images/products/flash-1.png",
  },
  {
    imgUrl: "/assets/images/products/flash-2.png",
  },
  {
    imgUrl: "/assets/images/products/flash-3.png",
  },
  {
    imgUrl: "/assets/images/products/flash-4.png",
  },
  {
    imgUrl: "/assets/images/products/flash-1.png",
  },
  {
    imgUrl: "/assets/images/products/flash-2.png",
  },
  {
    imgUrl: "/assets/images/products/flash-3.png",
  },
  {
    imgUrl: "/assets/images/products/flash-4.png",
  },
  {
    imgUrl: "/assets/images/products/flash-1.png",
  },
  {
    imgUrl: "/assets/images/products/flash-2.png",
  },
];

export default Section2;
