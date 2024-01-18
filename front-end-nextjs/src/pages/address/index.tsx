import Button from "@component/buttons/Button";
import IconButton from "@component/buttons/IconButton";
import FlexBox from "@component/FlexBox";
import Icon from "@component/icon/Icon";
import DashboardLayout from "@component/layout/CustomerDashboardLayout";
import DashboardPageHeader from "@component/layout/DashboardPageHeader";
import Pagination from "@component/pagination/Pagination";
import TableRow from "@component/TableRow";
import Typography, { H2 } from "@component/Typography";
import { AuthContext } from "@context/AuthProvider";
import { CustomerAddressesWithPagination } from "interfaces/api-response";
import { customerAddress, deleteCustomerAddress } from "@data/apis";
import Link from "next/link";
import React, { useContext, useEffect, useState } from "react";

const AddressList = () => {
  const { makeAuthenticatedRequest } = useContext(AuthContext);
  const [addressesData, setAddressesData] =
    useState<CustomerAddressesWithPagination | null>(null);

  // delete Handler
  const deleteHandler = (recordId) => {
    console.log(recordId, "recordId");
    // get the address for this user
    makeAuthenticatedRequest(
      `${deleteCustomerAddress.url}/${recordId}`,
      deleteCustomerAddress.method,
      deleteCustomerAddress.error_status_code
    )
      .then((data) => {
        console.log(data, "data from delete handler");
        setAddressesData(data);
      })
      .catch((error) => {
        console.error("Error fetching profile data:", error);
      });
  };

  const [page, setPage] = useState<number>(1);
  console.log(addressesData, "orders data");
  // make order request after component mounted.
  useEffect(() => {
    // get the address for this user
    makeAuthenticatedRequest(
      `${customerAddress.url}?page=` + page,
      customerAddress.method,
      customerAddress.error_status_code
    )
      .then((data) => {
        setAddressesData(data);
      })
      .catch((error) => {
        console.error("Error fetching profile data:", error);
      });
  }, [page]);

  return (
    <div>
      <DashboardPageHeader
        title="My Addresses"
        iconName="pin_filled"
        button={
          <Button color="primary" bg="primary.light" px="2rem">
            Add New Address
          </Button>
        }
      />

      {addressesData?.data.map((address) => (
        <TableRow my="1rem" padding="6px 18px" key={address.id}>
          <Typography className="pre" m="6px" textAlign="left">
            {address.name}
          </Typography>
          <Typography flex="1 1 260px !important" m="6px" textAlign="left">
            {address.address}
          </Typography>
          <Typography className="pre" m="6px" textAlign="left">
            {address.phone}
          </Typography>

          <Typography className="pre" textAlign="center" color="text.muted">
            <Link href={`/address/${address.id}`}>
              <Typography
                as="a"
                href={`/address/${address.id}`}
                color="inherit"
              >
                <IconButton size="small">
                  <Icon variant="small" defaultcolor="currentColor">
                    edit
                  </Icon>
                </IconButton>
              </Typography>
            </Link>
            <IconButton
              size="small"
              value={address.id}
              onClick={(e) => {
                e.stopPropagation();
                deleteHandler(address.id);
              }}
            >
              <Icon variant="small" defaultcolor="currentColor">
                delete
              </Icon>
            </IconButton>
          </Typography>
        </TableRow>
      ))}

      {addressesData?.meta.last_page > 1 ? (
        <FlexBox justifyContent="center" mt="2.5rem">
          {/* <Pagination
          pageCount={5}
          onChange={(data) => {
            console.log(data.selected);
          }}
        /> */}
          <Pagination
            pageCount={addressesData?.meta.last_page}
            setPage={setPage}
          />
        </FlexBox>
      ) : (
        ""
      )}
      {/* no records found status */}
      {addressesData?.data.length > 0 || (
        <H2 textAlign={"center"}>No Records Found</H2>
      )}
    </div>
  );
};

AddressList.layout = DashboardLayout;

export default AddressList;
