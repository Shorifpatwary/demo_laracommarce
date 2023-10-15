import Box from "@component/Box";
import Carousel from "@component/carousel/Carousel";
import CategorySectionCreator from "@component/CategorySectionCreator";
import ProductCard2 from "@component/product-cards/ProductCard2";
import { newArrival } from "@data/apis";
import useWindowSize from "@hook/useWindowSize";
import { ProductInterface } from "interfaces/api-response";
import React, { useEffect, useState } from "react";

const Section4: React.FC = () => {
  const [visibleSlides, setVisibleSlides] = useState(6);
  const [products, setProducts] = useState<ProductInterface[]>(null);

  const width = useWindowSize();

  useEffect(() => {
    if (width < 500) setVisibleSlides(2);
    else if (width < 650) setVisibleSlides(3);
    else if (width < 950) setVisibleSlides(4);
    else setVisibleSlides(6);
  }, [width]);

  useEffect(() => {
    fetch(`${newArrival.url}`)
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
      iconName="new-product-1"
      title="New Arrivals"
      seeMoreLink="#"
    >
      <Box mt="-0.25rem" mb="-0.25rem">
        <Carousel totalSlides={products?.length} visibleSlides={visibleSlides}>
          {products?.map((product) => (
            <Box py="0.25rem" key={product.id}>
              <ProductCard2 product={product} />
            </Box>
          ))}
        </Carousel>
      </Box>
    </CategorySectionCreator>
  );
};

const productList = [
  {
    title: "Sunglass",
    price: 150,
    imgUrl: "/assets/images/products/imagegoggles.png",
    productUrl: "/product/b1",
  },
  {
    title: "Makeup",
    price: 250,
    imgUrl: "/assets/images/products/lipstick (2).png",
    productUrl: "/product/b12",
  },
  {
    title: "Smart Watch",
    price: 350,
    imgUrl: "/assets/images/products/bgwatch.png",
    productUrl: "/product/b13",
  },
  {
    title: "Lipstick",
    price: 15,
    imgUrl: "/assets/images/products/lipstick (1).png",
    productUrl: "/product/b14",
  },
  {
    title: "Green plant",
    price: 55,
    imgUrl: "/assets/images/products/lipstick (4).png",
    productUrl: "/product/b15",
  },
  {
    title: "Bonsai tree",
    price: 535,
    imgUrl: "/assets/images/products/lipstick (3).png",
    productUrl: "/product/b16",
  },
  {
    title: "Sunglass",
    price: 150,
    imgUrl: "/assets/images/products/imagegoggles.png",
    productUrl: "/product/b17",
  },
  {
    title: "Makeup",
    price: 250,
    imgUrl: "/assets/images/products/lipstick (2).png",
    productUrl: "/product/b18",
  },
  {
    title: "Smart Watch",
    price: 350,
    imgUrl: "/assets/images/products/bgwatch.png",
    productUrl: "/product/b19",
  },
];

export default Section4;
