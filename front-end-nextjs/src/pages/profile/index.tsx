import Avatar from "@component/avatar/Avatar";
import Box from "@component/Box";
import Button from "@component/buttons/Button";
import Card from "@component/Card";
import FlexBox from "@component/FlexBox";
import Grid from "@component/grid/Grid";
import DashboardLayout from "@component/layout/CustomerDashboardLayout";
import DashboardPageHeader from "@component/layout/DashboardPageHeader";
import TableRow from "@component/TableRow";
import Typography, { H3, H5, Small } from "@component/Typography";
import { AuthContext } from "@context/AuthProvider";
import { format } from "date-fns";
import Link from "next/link";
import React, { useEffect, useState, useContext } from "react";
import { customerProfile } from "@data/apis";
import { useRouter } from "next/router";

const Profile = () => {
  const { makeAuthenticatedRequest, isAuthenticatedUser } =
    useContext(AuthContext);
  const authContext = useContext(AuthContext);
  const [isAuthenticateUser, setIsAuthenticateUser] = useState(false);

  async function checkAuthentication() {
    const isAuthenticated = await isAuthenticatedUser();
    setIsAuthenticateUser(isAuthenticated);
  }

  const [profileData, setProfileData] = useState(null);
  const router = useRouter();

  useEffect(() => {
    checkAuthentication();
    if (isAuthenticateUser) {
      router.back();
    }
    // Example: Make an authenticated API request
    makeAuthenticatedRequest(customerProfile.url, customerProfile.method)
      .then((data) => {
        setProfileData(data.customer);
      })
      .catch((error) => {
        console.error("Error fetching profile data:", error);
      });
  }, []);

  return (
    <div>
      <DashboardPageHeader
        iconName="user_filled"
        title="My Profile"
        button={
          <FlexBox>
            {/* <Link href="/logout"> */}
            <Button
              onClick={() => authContext.Logout()}
              color="primary"
              bg="primary.light"
              px="2rem"
              marginX="0.5rem"
            >
              Log-Out
            </Button>
            {/* </Link> */}
            <Link href="/profile/edit">
              <Button color="success" bg="success.light" px="2rem">
                Edit Profile
              </Button>
            </Link>
          </FlexBox>
        }
      />

      <Box mb="30px">
        <Grid container spacing={6}>
          <Grid item lg={6} md={6} sm={12} xs={12}>
            <FlexBox as={Card} p="14px 32px" height="100%" alignItems="center">
              {/* <Avatar src="/assets/images/faces/ralph.png" size={64} /> */}
              <Typography
                color="text.hint"
                letterSpacing="0.1rem"
                fontWeight={700}
              >
                User Name:
              </Typography>
              <Box ml="12px" flex="1 1 0">
                <FlexBox
                  flexWrap="wrap"
                  justifyContent="space-between"
                  alignItems="center"
                >
                  <div>
                    <H5 my="0px">{profileData?.name}</H5>
                    {/* <FlexBox alignItems="center">
                      <Typography fontSize="14px" color="text.hint">
                        Balance:
                      </Typography>
                      <Typography ml="4px" fontSize="14px" color="primary.main">
                        $500
                      </Typography>
                    </FlexBox> */}
                  </div>

                  <Typography
                    ontSize="14px"
                    color="text.hint"
                    letterSpacing="0.2em"
                  >
                    SILVER USER
                  </Typography>
                </FlexBox>
              </Box>
            </FlexBox>
          </Grid>

          {/* <Grid item lg={6} md={6} sm={12} xs={12}>
            <Grid container spacing={4}>
              {infoList.map((item) => (
                <Grid item lg={3} sm={6} xs={6} key={item.subtitle}>
                  <FlexBox
                    as={Card}
                    flexDirection="column"
                    alignItems="center"
                    height="100%"
                    p="1rem 1.25rem"
                  >
                    <H3 color="primary.main" my="0px" fontWeight="600">
                      {item.title}
                    </H3>
                    <Small color="text.muted" textAlign="center">
                      {item.subtitle}
                    </Small>
                  </FlexBox>
                </Grid>
              ))}
            </Grid>
          </Grid> */}
        </Grid>
      </Box>

      <TableRow p="0.75rem 1.5rem">
        <FlexBox flexDirection="column" p="0.5rem">
          <Small color="text.muted" mb="4px" textAlign="left">
            User Name
          </Small>
          <span>{profileData?.name}</span>
        </FlexBox>
        {/* <FlexBox flexDirection="column" p="0.5rem">
          <Small color="text.muted" mb="4px" textAlign="left">
            Last Name
          </Small>
          <span>Edwards</span>
        </FlexBox> */}
        <FlexBox flexDirection="column" p="0.5rem">
          <Small color="text.muted" mb="4px" textAlign="left">
            Email
          </Small>
          <span>{profileData?.email}</span>
        </FlexBox>
        <FlexBox flexDirection="column" p="0.5rem">
          <Small color="text.muted" mb="4px" textAlign="left">
            Phone
          </Small>
          <span>{profileData?.phone}</span>
        </FlexBox>
        <FlexBox flexDirection="column" p="0.5rem">
          <Small color="text.muted" mb="4px">
            Birth date
          </Small>
          {/* <span className="pre">
            {format(new Date(1996 / 11 / 16), "dd MMM, yyyy")}
          </span> */}
          <span className="pre">{profileData?.birth_date}</span>
        </FlexBox>
      </TableRow>
    </div>
  );
};

Profile.layout = DashboardLayout;

export default Profile;
