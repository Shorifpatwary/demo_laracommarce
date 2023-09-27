<FlexBox className="header-right" alignItems="center">
  <UserLoginDialog
    handle={
      <IconButton ml="1rem" bg="gray.200" p="8px">
        <Icon size="28px">user</Icon>
      </IconButton>
    }
  >
    <Box>
      <Login />
    </Box>
  </UserLoginDialog>

  <Sidenav
    handle={cartHandle}
    position="right"
    open={open}
    width={380}
    toggleSidenav={toggleSidenav}
  >
    <MiniCart toggleSidenav={toggleSidenav} />
  </Sidenav>
</FlexBox>;
