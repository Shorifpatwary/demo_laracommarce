import IconButton from "@component/buttons/IconButton";
import Image from "@component/Image";
import { useAppContext } from "@context/app/AppContext";
import Link from "next/link";
import React, { useContext, useEffect, useState } from "react";
import Box from "../Box";
import Categories from "../categories/Categories";
import Container from "../Container";
import FlexBox from "../FlexBox";
import Icon from "../icon/Icon";
import MiniCart from "../mini-cart/MiniCart";
import SearchBox from "../search-box/SearchBox";
import Login from "../sessions/Login";
import Sidenav from "../sidenav/Sidenav";
import { Tiny } from "../Typography";
import StyledHeader from "./HeaderStyle";
import UserLoginDialog from "./UserLoginDialog";
import UserProfileDialog from "./UserProfileDialog";
import Button from "@component/buttons/Button";
import { AuthContext } from "@context/AuthProvider";
import getCookie from "functions/getCookie";

type HeaderProps = {
  isFixed?: boolean;
  className?: string;
};

const Header: React.FC<HeaderProps> = ({ isFixed, className }) => {
  const [open, setOpen] = useState(false);
  const toggleSidenav = () => setOpen(!open);

  const { isAuthenticatedUser } = useContext(AuthContext);
  const [isAuthenticateUser, setIsAuthenticateUser] = useState(false);

  async function checkAuthentication() {
    const isAuthenticated = await isAuthenticatedUser();
    setIsAuthenticateUser(isAuthenticated);
  }
  useEffect(() => {
    checkAuthentication();
  });

  // const { contextValue } = useAppContext();
  const { state } = useAppContext().contextValue;
  const { cartList } = state.cart;

  const cartHandle = (
    <FlexBox ml="20px" alignItems="flex-start">
      <IconButton bg="gray.200" p="12px">
        <Icon size="20px">bag</Icon>
      </IconButton>

      {!!cartList.length && (
        <FlexBox
          borderRadius="300px"
          bg="error.main"
          px="5px"
          py="2px"
          alignItems="center"
          justifyContent="center"
          ml="-1rem"
          mt="-9px"
        >
          <Tiny color="white" fontWeight="600">
            {cartList.length}
          </Tiny>
        </FlexBox>
      )}
    </FlexBox>
  );

  return (
    <StyledHeader className={className}>
      <Container
        display="flex"
        alignItems="center"
        justifyContent="space-between"
        height="100%"
      >
        <FlexBox className="logo" alignItems="center" mr="1rem">
          <Link href="/">
            <a>
              <Image src="/assets/images/logo.svg" alt="logo" />
            </a>
          </Link>

          {isFixed && (
            <div className="category-holder">
              <Categories>
                <FlexBox color="text.hint" alignItems="center" ml="1rem">
                  <Icon>categories</Icon>
                  <Icon>arrow-down-filled</Icon>
                </FlexBox>
              </Categories>
            </div>
          )}
        </FlexBox>

        <FlexBox justifyContent="center" flex="1 1 0">
          <SearchBox />
          {
            <Link href={isAuthenticateUser ? "/profile" : "/login"}>
              <IconButton ml="1rem" bg="gray.200" p="8px">
                <Icon size="28px">user</Icon>
              </IconButton>
            </Link>
          }
        </FlexBox>

        <FlexBox className="header-right" alignItems="center">
          <Sidenav
            handle={cartHandle}
            position="right"
            open={open}
            width={380}
            toggleSidenav={toggleSidenav}
          >
            <MiniCart toggleSidenav={toggleSidenav} />
          </Sidenav>
        </FlexBox>
      </Container>
    </StyledHeader>
  );
};

export default Header;

{
  /* <UserProfileDialog
  handle={
    <IconButton ml="1rem" bg="gray.200" p="8px">
      <Icon size="28px">user</Icon>
    </IconButton>
  }
>
  <Box>
    <UserLoginDialog
      handle={
        <Button ml="1rem" bg="gray.200" p="8px">
          Log in
        </Button>
      }
    >
      <Login />
    </UserLoginDialog>
  </Box>
</UserProfileDialog>; */
}
