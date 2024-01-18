import Card from "@component/Card";
import { Card1 } from "@component/Card1";
import Divider from "@component/Divider";
import FlexBox from "@component/FlexBox";
import Typography, { H5, Span, Tiny } from "@component/Typography";
import Avatar from "@component/avatar/Avatar";
import Button from "@component/buttons/Button";
import Grid from "@component/grid/Grid";
import CheckoutNavLayout from "@component/layout/CheckoutNavLayout";
import { useAppContext } from "@context/app/AppContext";
import { CartItem } from "@reducer/cartReducer";
import Link from "next/link";
import React, { Fragment, useContext, useState } from "react";
import { createOrder } from "@data/apis";
import { AuthContext } from "@context/AuthProvider";
import { useRouter } from "next/router";

const OrderPreview = () => {
  const router = useRouter();
  const { state, dispatch } = useAppContext();

  const { makeAuthenticatedRequest } = useContext(AuthContext);

  const { cartList } = state.cart;

  const orderState = state.order;
  const orderValue = {
    note: state.order.note,
    order_items: state.cart.cartList,
    shipping_name: state.order.shippingAddress.name,
    shipping_phone: state.order.shippingAddress.phoneNumber,
    shipping_address: state.order.shippingAddress.address,
    shipping_postal_code: state.order.shippingAddress.postal_code,
    isBillingAddressSame: state.order.isBillingAddressSame,
    billing_name: state.order.billingAddress.name,
    billing_phone: state.order.billingAddress.phoneNumber,
    billing_address: state.order.billingAddress.address,
    billing_postal_code: state.order.billingAddress.postal_code,
  };
  const handleOrderClick = async () => {
    try {
      const data = await makeAuthenticatedRequest(
        createOrder.url,
        createOrder.method,
        createOrder.error_status_code,
        orderValue
      );

      if (data && data.errors) {
        console.log(data.status, "data status ", data, "request data ");
        const serverErrors = data.errors;
        // Set the server-side errors to the Formik's errors object
        dispatch({
          type: "SET_ERROR",
          payload: serverErrors,
        });
      } else {
        dispatch({
          type: "CLEAR_ORDER",
        });
        dispatch({
          type: "CLEAR_CART",
        });
        // push to the payment page or order page
        router.push("/orders");
      }
    } catch (error) {
      console.log(error, "make auth");
    }
  };

  return (
    <>
      {state.order.errors ? (
        <div className="error">
          <h3 color="error">Error Found:</h3>
          <ul>
            {Object.entries(state.order.errors).map(([field, messages]) => (
              <li key={field}>
                <strong>{field}:</strong>
                <ul>
                  {messages.map((message, index) => (
                    <li key={index}>{message}</li>
                  ))}
                </ul>
              </li>
            ))}
          </ul>
        </div>
      ) : (
        ""
      )}

      <Grid
        container
        flexWrap="wrap-reverse"
        flexDirection="column"
        spacing={6}
      >
        <Grid>
          <Typography
            fontSize={30}
            fontWeight="600"
            textAlign="center"
            mb="1rem"
            color="secondary.main"
          >
            Preview Order
          </Typography>

          {/* order info */}
          <Card1>
            <Typography fontSize={24} fontWeight={400} my={"0.5rem"}>
              Order info
            </Typography>
            <Divider />
            <span> Order Note: {orderState.note}</span>
          </Card1>
          {/* order cart data */}
          <Card1>
            <Typography fontSize={24} fontWeight={400} my={"0.5rem"}>
              Products
            </Typography>
            <Divider />
            <FlexBox
              flexWrap="wrap"
              alignItems="flex-start"
              flexDirection="column"
            >
              {cartList.map((item: CartItem) => (
                <Fragment key={item.id}>
                  <FlexBox flexDirection="row" alignItems="flex-start">
                    {/* <FlexBox alignItems="center" flexDirection="row">
                      <Typography fontWeight={600} fontSize="15px" my="3px">
                        Total:{item.qty}
                      </Typography>
                    </FlexBox> */}

                    <Link href={`/product/${item.id}`}>
                      <a>
                        <Avatar
                          src={
                            item.imgUrl ||
                            "/assets/images/products/iphone-x.png"
                          }
                          mx="1rem"
                          alt={item.name}
                          size={76}
                        />
                      </a>
                    </Link>

                    <FlexBox
                      className="product-details"
                      flexDirection="column"
                      alignItems="baseline"
                    >
                      <Link href={`/product/${item.id}`}>
                        <a>
                          <H5 className="title" fontSize="14px">
                            {item.name}
                          </H5>
                        </a>
                      </Link>
                      <Tiny color="text.muted">
                        ${item.price} x {item.qty}
                        {/* ${item.price.toFixed(2)} x {item.qty} */}
                      </Tiny>
                      <Typography
                        fontWeight={600}
                        fontSize="14px"
                        color="primary.main"
                        mt="4px"
                      >
                        ${item.qty * item.price}
                        {/* ${(item.qty * item.price).toFixed(2)} */}
                      </Typography>
                    </FlexBox>
                  </FlexBox>
                  <Divider />
                </Fragment>
              ))}
            </FlexBox>
          </Card1>
          {/*  address */}
          <Card1 mb="2rem" padding="5">
            <Typography fontSize={24} fontWeight={400} my={"0.5rem"}>
              Shipping Address
            </Typography>
            <Divider />
            <FlexBox flexDirection="column">
              <span> name: {orderState.shippingAddress.name}</span>
              <span>
                phone number: {orderState.shippingAddress.phoneNumber}
              </span>
              <span> address: {orderState.shippingAddress.address}</span>
              <span>postal code: {orderState.shippingAddress.postal_code}</span>
            </FlexBox>
            <Typography fontSize={24} fontWeight={400} my={"0.5rem"}>
              Billing Address
            </Typography>
            <Divider />
            {orderState.isBillingAddressSame ? (
              // show shipping address data instead of billing address
              <FlexBox flexDirection="column">
                <span> name: {orderState.shippingAddress.name}</span>
                <span>
                  phone number: {orderState.shippingAddress.phoneNumber}
                </span>
                <span> address: {orderState.shippingAddress.address}</span>
                <span>
                  postal code: {orderState.shippingAddress.postal_code}
                </span>
              </FlexBox>
            ) : (
              <FlexBox flexDirection="column">
                <span> name: {orderState.billingAddress.name}</span>
                <span>
                  phone number: {orderState.billingAddress.phoneNumber}
                </span>
                <span> address: {orderState.billingAddress.address}</span>
                <span>
                  postal code: {orderState.billingAddress.postal_code}
                </span>
              </FlexBox>
            )}
          </Card1>
          <Card1 mb="2rem">
            <Typography color="primary.main">
              Payment Method : {orderState.paymentMethod}
            </Typography>
          </Card1>
          <Grid container spacing={7}>
            <Grid item sm={6} xs={12}>
              <Link href="/payment">
                <Button
                  variant="outlined"
                  color="primary"
                  type="button"
                  fullwidth
                >
                  Back to payment
                </Button>
              </Link>
            </Grid>
            <Grid item sm={6} xs={12}>
              <Button
                variant="contained"
                color="primary"
                type="submit"
                fullwidth
                onClick={handleOrderClick}
              >
                Confirm Order
              </Button>
            </Grid>
          </Grid>
        </Grid>
      </Grid>
    </>
  );
};

OrderPreview.layout = CheckoutNavLayout;

export default OrderPreview;
