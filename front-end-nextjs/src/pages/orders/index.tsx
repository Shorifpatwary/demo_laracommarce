import CustomerDashboardLayout from "@component/layout/CustomerDashboardLayout";
import CustomerOrderList from "@component/orders/CustomerOrderList";
import React, { useContext, useEffect, useState } from "react";
import { OrdersWithPagination } from "interfaces/api-response";
import { AuthContext } from "@context/AuthProvider";
import { orders } from "@data/apis";
import { H2 } from "@component/Typography";

export interface CustomerOrderListProps {}

const Orders = () => {
  const { makeAuthenticatedRequest } = useContext(AuthContext);
  const [ordersData, setOrdersData] = useState<OrdersWithPagination | null>(
    null
  );
  const [page, setPage] = useState<number>(1);
  console.log(ordersData, "orders data");
  // make order request after component mounted.
  useEffect(() => {
    // Example: Make an authenticated API request
    makeAuthenticatedRequest(
      `${orders.url}?page=` + page,
      orders.method,
      orders.error_status_code
    )
      .then((data) => {
        setOrdersData(data);
      })
      .catch((error) => {
        console.error("Error fetching profile data:", error);
      });
  }, [page]);

  return ordersData ? (
    <CustomerOrderList ordersData={ordersData} setPage={setPage} />
  ) : (
    <H2 textAlign="center"> Data Loading</H2>
  );
};

Orders.layout = CustomerDashboardLayout;
export default Orders;
