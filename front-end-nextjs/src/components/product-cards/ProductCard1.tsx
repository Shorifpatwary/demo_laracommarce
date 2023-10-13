import ProductIntro from "@component/products/ProductIntro";
import { useAppContext } from "@context/app/AppContext";
import { CartItem } from "@reducer/cartReducer";
import Image from "next/image";
import Link from "next/link";
import React, { Fragment, useCallback, useState } from "react";
import { CSSProperties } from "styled-components";
import Box from "../Box";
import Button from "../buttons/Button";
import Card, { CardProps } from "../Card";
import { Chip } from "../Chip";
import FlexBox from "../FlexBox";
import Icon from "../icon/Icon";
import Modal from "../modal/Modal";
import Rating from "../rating/Rating";
import { H3, SemiSpan } from "../Typography";
import { StyledProductCard1 } from "./ProductCardStyle";
import { ProductInterface } from "interfaces/api-response";
export interface ProductCard1Props extends CardProps {
  product: ProductInterface;
  [key: string]: unknown;
}
// export interface ProductCard1Props extends CardProps {
//   className?: string;
//   style?: CSSProperties;
//   imgUrl?: string;
//   title?: string;
//   price?: number;
//   off?: number;
//   rating?: number;
//   id?: string | number;
//   // className?: string;
//   // style?: CSSProperties;
//   // imgUrl: string;
//   // title: string;
//   // price: number;
//   // off: number;
//   // rating?: number;
//   // subcategories?: Array<{
//   //   title: string;
//   //   url: string;
//   // }>;
// }

const ProductCard1: React.FC<ProductCard1Props> = ({ product, ...props }) => {
  const {
    id,
    thumbnail_link,
    images_link,
    name,
    selling_price,
    discount_price,
    // rating,
  } = product;
  const [open, setOpen] = useState(false);

  const { state, dispatch } = useAppContext();
  const cartItem: CartItem = state.cart.cartList.find(
    (item) => parseInt(item.id) === product.id
  );

  const toggleDialog = useCallback(() => {
    setOpen((open) => !open);
  }, []);

  const handleCartAmountChange = useCallback(
    (amount) => () => {
      dispatch({
        type: "CHANGE_CART_AMOUNT",
        payload: {
          name: name,
          qty: amount,
          selling_price,
          discount_price,
          thumbnail_link,
          brand,
          id,
        },
      });
    },
    []
  );

  return (
    <StyledProductCard1 {...props}>
      <div className="image-holder">
        {!!discount_price && (
          <Chip
            position="absolute"
            bg="primary.main"
            color="primary.text"
            fontSize="10px"
            fontWeight="600"
            p="5px 10px"
            top="10px"
            left="10px"
          >
            ${discount_price} off
          </Chip>
        )}

        <FlexBox className="extra-icons">
          <Icon
            color="secondary"
            variant="small"
            mb="0.5rem"
            onClick={toggleDialog}
          >
            eye-alt
          </Icon>

          <Icon className="favorite-icon outlined-icon" variant="small">
            heart
          </Icon>
          {/* <Icon className="favorite-icon" color="primary" variant="small">
              heart-filled
            </Icon> */}
        </FlexBox>

        <Link href={`/product/${id}`}>
          <a>
            {/* <img src={thumbnail_link} alt="" /> */}
            <Image
              src={thumbnail_link}
              // src="http://localhost:8000/files/product/simple-product-name1777520611797309.jpg"
              // src="/assets/images/products/macbook.png"
              layout="responsive"
              alt={name}
              width={100}
              height={100}
              blurDataURL="/assets/images/products/macbook.png"
              placeholder="blur"
              unoptimized // Disable optimization for this image
            />
          </a>
        </Link>
      </div>
      <div className="details">
        <FlexBox>
          <Box flex="1 1 0" minWidth="0px" mr="0.5rem">
            <Link href={`/product/${id}`}>
              <a>
                <H3
                  className="title"
                  fontSize="14px"
                  textAlign="left"
                  fontWeight="600"
                  color="text.secondary"
                  mb="10px"
                  title={name}
                >
                  {name}
                </H3>
              </a>
            </Link>

            {/* <Rating value={rating || 0} outof={5} color="warn" readonly /> */}

            <FlexBox alignItems="center" mt="10px">
              <SemiSpan pr="0.5rem" fontWeight="600" color="primary.main">
                {/* ${(selling_price - (selling_price * off) / 100).toFixed(2)} */}
                {selling_price}
              </SemiSpan>
              {!!discount_price && (
                <SemiSpan color="text.muted" fontWeight="600">
                  {/* <del>{selling_price?.toFixed(2)}</del> */}
                  <del>
                    {parseInt(selling_price) + parseInt(discount_price || 0)}
                  </del>
                </SemiSpan>
              )}
            </FlexBox>
          </Box>

          <FlexBox
            flexDirection="column-reverse"
            alignItems="center"
            justifyContent={!!cartItem?.qty ? "space-between" : "flex-start"}
            width="30px"
          >
            {/* <div className="add-cart"> */}
            <Button
              variant="outlined"
              color="primary"
              padding="3px"
              size="none"
              borderColor="primary.light"
              onClick={handleCartAmountChange((cartItem?.qty || 0) + 1)}
            >
              <Icon variant="small">plus</Icon>
            </Button>

            {!!cartItem?.qty && (
              <Fragment>
                <SemiSpan color="text.primary" fontWeight="600">
                  {cartItem?.qty}
                </SemiSpan>
                <Button
                  variant="outlined"
                  color="primary"
                  padding="3px"
                  size="none"
                  borderColor="primary.light"
                  onClick={handleCartAmountChange(cartItem?.qty - 1)}
                >
                  <Icon variant="small">minus</Icon>
                </Button>
              </Fragment>
            )}
          </FlexBox>
        </FlexBox>
      </div>

      <Modal open={open} onClose={toggleDialog}>
        <Card p="1rem" position="relative">
          <ProductIntro
            imgUrl={images_link}
            title={name}
            price={selling_price}
            brandName={product.brand.name}
            id={id}
          />
          <Box
            position="absolute"
            top="0.75rem"
            right="0.75rem"
            cursor="pointer"
          >
            <Icon
              className="close"
              color="primary"
              variant="small"
              onClick={toggleDialog}
            >
              close
            </Icon>
          </Box>
        </Card>
      </Modal>
    </StyledProductCard1>
  );
};

ProductCard1.defaultProps = {
  id: "324321",
  title: "KSUS ROG Strix G15",
  imgUrl: "/assets/images/products/macbook.png",
  off: 50,
  price: 450,
  rating: 0,
};

export default ProductCard1;
