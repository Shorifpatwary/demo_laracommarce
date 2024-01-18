import React, { useContext, useEffect, useState } from "react";
import FlexBox from "../FlexBox";
import Hidden from "../hidden/Hidden";
import DashboardPageHeader from "../layout/DashboardPageHeader";
import Pagination from "../pagination/Pagination";
import TableRow from "../TableRow";
import { H5 } from "../Typography";
import OrderRow from "./OrderRow";
import { AuthContext } from "@context/AuthProvider";
import { OrderInterface, OrdersWithPagination } from "interfaces/api-response";
export interface CustomerOrderListProps {
  ordersData: OrdersWithPagination;
  setPage: React.Dispatch<React.SetStateAction<number>>;
}

const CustomerOrderList: React.FC<CustomerOrderListProps> = ({
  ordersData,
  setPage,
}) => {
  return (
    <div>
      <DashboardPageHeader title="My Orders" iconName="bag_filled" />

      <Hidden down={769}>
        <TableRow padding="0px 18px" boxShadow="none" bg="none">
          <H5 color="text.muted" my="0px" mx="6px" textAlign="left">
            Order #
          </H5>
          <H5 color="text.muted" my="0px" mx="6px" textAlign="left">
            Status
          </H5>
          <H5 color="text.muted" my="0px" mx="6px" textAlign="left">
            Date purchased
          </H5>
          <H5 color="text.muted" my="0px" mx="6px" textAlign="left">
            Total
          </H5>
          <H5
            flex="0 0 0 !important"
            color="text.muted"
            px="22px"
            my="0px"
          ></H5>
        </TableRow>
      </Hidden>

      {ordersData.data.map((item, index) => (
        <OrderRow
          item={item}
          key={item.id}
          SL_no={ordersData?.meta.from + index}
        />
      ))}

      <FlexBox justifyContent="center" mt="2.5rem">
        <Pagination pageCount={ordersData?.meta.last_page} setPage={setPage} />
      </FlexBox>
    </div>
  );
};

export default CustomerOrderList;
