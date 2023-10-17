import Link from "next/link";
import Image from "@component/Image";
import { CartItem } from "@reducer/cartReducer";
import { useAppContext } from "@context/app/AppContext";
import { useRouter } from "next/router";
import React, { useCallback, useEffect, useState } from "react";
import Avatar from "../avatar/Avatar";
import Box from "../Box";
import Button from "../buttons/Button";
import FlexBox from "../FlexBox";
import Grid from "../grid/Grid";
import Icon from "../icon/Icon";
import Rating from "../rating/Rating";
import { H1, H2, H3, H6, SemiSpan } from "../Typography";
import { BrandInterface, ProductInterface } from "interfaces/api-response";

export interface ProductIntroProps {
  product: ProductInterface;
}

const ProductIntro: React.FC<ProductIntroProps> = ({ product }) => {
  const [selectedImage, setSelectedImage] = useState(0);
  const { state, dispatch } = useAppContext();
  const cartList: CartItem[] = state.cart.cartList;
  const router = useRouter();
  const routerId = router.query.id as string;

  const cartItem = cartList.find(
    (item) => item.id === product.id || item.id === routerId
  );

  const handleImageClick = (imageIndex) => () => {
    setSelectedImage(imageIndex);
  };

  useEffect(() => {
    // Bug fix:: update selected image state when page initialize
    setSelectedImage(0);
  }, [router.query]);

  const handleCartAmountChange = useCallback(
    (amount) => () => {
      dispatch({
        type: "CHANGE_CART_AMOUNT",
        payload: {
          qty: amount,
          name: product.name,
          price: product.selling_price,
          imgUrl: product.thumbnail_link,
          id: product.id || routerId,
        },
      });
    },
    []
  );

  return (
    <Box overflow="hidden">
      <Grid container justifyContent="center" spacing={16}>
        <Grid item md={6} xs={12} alignItems="center">
          <Box>
            <FlexBox justifyContent="center" mb="50px">
              <Image
                width={300}
                height={300}
                src={product.images_link[selectedImage]}
                style={{ objectFit: "contain" }}
              />
            </FlexBox>
            <FlexBox overflow="auto">
              {product.images_link.map((url, ind) => (
                <Box
                  size={70}
                  minWidth={70}
                  bg="white"
                  borderRadius="10px"
                  display="flex"
                  justifyContent="center"
                  alignItems="center"
                  cursor="pointer"
                  border="1px solid"
                  key={ind}
                  ml={ind === 0 && "auto"}
                  mr={ind === product.images_link.length - 1 ? "auto" : "10px"}
                  borderColor={
                    selectedImage === ind ? "primary.main" : "gray.400"
                  }
                  onClick={handleImageClick(ind)}
                >
                  <Avatar src={url} borderRadius="10px" size={40} />
                </Box>
              ))}
            </FlexBox>
          </Box>
        </Grid>

        <Grid item md={6} xs={12} alignItems="center">
          <H1 mb="1rem">{product.name}</H1>

          {!!product.brand?.name ? (
            <FlexBox alignItems="center" mb="1rem">
              <SemiSpan>Brand:</SemiSpan>
              <H6 ml="8px">{product.brand.name}</H6>
            </FlexBox>
          ) : (
            " "
          )}

          <FlexBox alignItems="center" mb="1rem">
            <SemiSpan>Rated:</SemiSpan>
            <Box ml="8px" mr="8px">
              <Rating color="warn" value={product.average_rating} outof={5} />
            </Box>
            <H6>({product.review.length})</H6>
          </FlexBox>

          <Box mb="24px">
            <H2 color="primary.main" mb="4px" lineHeight="1">
              ${product.selling_price}
            </H2>
            <SemiSpan color="inherit">Stock Available</SemiSpan>
          </Box>

          {!cartItem?.qty ? (
            <Button
              variant="contained"
              size="small"
              color="primary"
              mb="36px"
              onClick={handleCartAmountChange(1)}
            >
              Add to Cart
            </Button>
          ) : (
            <FlexBox alignItems="center" mb="36px">
              <Button
                p="9px"
                variant="outlined"
                size="small"
                color="primary"
                onClick={handleCartAmountChange(cartItem?.qty - 1)}
              >
                <Icon variant="small">minus</Icon>
              </Button>
              <H3 fontWeight="600" mx="20px">
                {cartItem?.qty.toString().padStart(2, "0")}
              </H3>
              <Button
                p="9px"
                variant="outlined"
                size="small"
                color="primary"
                onClick={handleCartAmountChange(cartItem?.qty + 1)}
              >
                <Icon variant="small">plus</Icon>
              </Button>
            </FlexBox>
          )}

          {/* <FlexBox alignItems="center" mb="1rem">
            <SemiSpan>Sold By:</SemiSpan>
            <Link href="/">
              <a>
                <H6 lineHeight="1" ml="8px">
                  Mobile Store
                </H6>
              </a>
            </Link>
          </FlexBox> */}
        </Grid>
      </Grid>
    </Box>
  );
};

export default ProductIntro;
