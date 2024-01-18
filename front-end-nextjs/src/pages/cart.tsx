import { useAppContext } from "@context/app/AppContext";
import { CartItem } from "@reducer/cartReducer";
import Link from "next/link";
import React, { Fragment, useCallback, useState } from "react";
import Box from "../components/Box";
import Button from "../components/buttons/Button";
import { Card1 } from "../components/Card1";
import Divider from "../components/Divider";
import FlexBox from "../components/FlexBox";
import Grid from "../components/grid/Grid";
import CheckoutNavLayout from "../components/layout/CheckoutNavLayout";
import ProductCard7 from "../components/product-cards/ProductCard7";
import Select from "../components/Select";
import TextField from "../components/text-field/TextField";
import TextArea from "../components/textarea/TextArea";
import Typography from "../components/Typography";
import countryList from "../data/countryList";
import { useRouter } from "next/router";

const Cart = () => {
  const router = useRouter();

  const { state, dispatch } = useAppContext();
  const cartList: CartItem[] = state.cart.cartList;
  console.log(state, "state");
  // handle note change
  const handleNoteChange = useCallback(
    (note) => {
      dispatch({
        type: "SET_NOTE",
        payload: note,
      });
    },
    [dispatch]
  );

  const getTotalPrice = () => {
    return (
      cartList.reduce(
        (accumulator, item) => accumulator + item.price * item.qty,
        0
      ) || 0
    );
  };
  // cart handler
  const cartHandler = () => {
    router.push("/checkout");
  };

  return (
    <Fragment>
      <Grid container spacing={6}>
        <Grid item lg={8} md={8} xs={12}>
          {cartList.map((item) => (
            <ProductCard7 key={item.id} mb="1.5rem" {...item} />
          ))}
        </Grid>
        <Grid item lg={4} md={4} xs={12}>
          <Card1>
            <FlexBox
              justifyContent="space-between"
              alignItems="center"
              mb="1rem"
            >
              <Typography color="gray.600">Total:</Typography>
              <FlexBox alignItems="flex-end">
                <Typography fontSize="18px" fontWeight="600" lineHeight="1">
                  ${getTotalPrice()}
                </Typography>
                <Typography fontWeight="600" fontSize="14px" lineHeight="1">
                  .00
                </Typography>
              </FlexBox>
            </FlexBox>

            <Divider mb="1rem" />

            <FlexBox alignItems="center" mb="1rem">
              <Typography fontWeight="600" mr="10px">
                Additional Comments
              </Typography>
              <Box p="3px 10px" bg="primary.light" borderRadius="3px">
                <Typography fontSize="12px" color="primary.main">
                  Note
                </Typography>
              </Box>
            </FlexBox>

            <TextArea
              rows={6}
              fullwidth
              mb="1rem"
              value={state.order.note || ""}
              onChange={(e) => handleNoteChange(e.currentTarget.value)}
            />

            <Divider mb="1rem" />

            {/* /voucher will show on checkout page */}
            {/* <TextField placeholder="Voucher" fullwidth />
            <Button
              variant="outlined"
              color="primary"
              mt="1rem"
              mb="30px"
              fullwidth
            >
              Apply Voucher
            </Button>
            <Divider mb="1.5rem" /> */}

            {/* <Typography fontWeight="600" mb="1rem">
              Shipping Estimates
            </Typography> */}

            {/* hide country.show only warehouse  */}
            {/* <Select
              mb="1rem"
              label="Country"
              placeholder="Select Country"
              options={countryList}
              onChange={(e) => {
                console.log(e);
              }}
            /> */}

            {/* <Select
              label="Ware House"
              placeholder="Select Ware House"
              options={stateList}
              onChange={(e) => {
                console.log(e);
              }}
            />

            <Box mt="1rem">
              <TextField label="Zip Code" placeholder="3100" fullwidth />
            </Box>

            <Button variant="outlined" color="primary" my="1rem" fullwidth>
              Calculate Shipping
            </Button> */}
            {/* <Link href="/checkout"> */}
            <Button
              onClick={cartHandler}
              variant="contained"
              color="primary"
              fullwidth
            >
              Checkout Now
            </Button>
            {/* </Link> */}
          </Card1>
        </Grid>
      </Grid>
    </Fragment>
  );
};

// const stateList = [
//   {
//     value: "New York",
//     label: "New York",
//   },
//   {
//     value: "Chicago",
//     label: "Chicago",
//   },
// ];

Cart.layout = CheckoutNavLayout;

export default Cart;
