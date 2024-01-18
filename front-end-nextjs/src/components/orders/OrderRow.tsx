import { format } from "date-fns";
import Link from "next/link";
import React from "react";
import Box from "../Box";
import IconButton from "../buttons/IconButton";
import { Chip } from "../Chip";
import Hidden from "../hidden/Hidden";
import Icon from "../icon/Icon";
import TableRow from "../TableRow";
import Typography, { H5, Small } from "../Typography";
import { OrderInterface } from "interfaces/api-response";

export interface OrderRowProps {
  item: OrderInterface;
  SL_no: number;
}

const OrderRow: React.FC<OrderRowProps> = ({ item, SL_no }) => {
  const getColor = (status) => {
    switch (status) {
      case "pending payment":
        return "secondary"; //  info
      case "processing":
        return "secondary";
      case "delivered":
        return "success";
      case "canceled":
        return "error";
      default:
        return "";
    }
  };

  return (
    <Link href={`/orders/${item.id}`}>
      <TableRow as="a" href={`/orders/${item.id}`} my="1rem" padding="6px 18px">
        <H5 m="6px" textAlign="left">
          {SL_no}
        </H5>
        <Box m="6px">
          <Chip p="0.25rem 1rem" bg={`${getColor(item.status)}.light`}>
            <Small color={`${getColor(item.status)}.main`}>{item.status}</Small>
          </Chip>
        </Box>
        <Typography className="flex-grow pre" m="6px" textAlign="left">
          {format(new Date(item.created_at), "MMM dd, yyyy")}
        </Typography>
        <Typography m="6px" textAlign="left">
          ${item.total_price.toFixed(2)}
        </Typography>

        <Hidden flex="0 0 0 !important" down={769}>
          <Typography textAlign="center" color="text.muted">
            <IconButton size="small">
              <Icon variant="small" defaultcolor="currentColor">
                arrow-right
              </Icon>
            </IconButton>
          </Typography>
        </Hidden>
      </TableRow>
    </Link>
  );
};

export default OrderRow;
