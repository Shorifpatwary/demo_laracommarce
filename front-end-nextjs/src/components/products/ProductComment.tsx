import React from "react";
import { getDateDifference } from "../../utils/utils";
import Avatar from "../avatar/Avatar";
import Box from "../Box";
import FlexBox from "../FlexBox";
import Rating from "../rating/Rating";
import { H5, H6, Paragraph, SemiSpan } from "../Typography";
import { productReviewInterface } from "interfaces/api-response";

export interface ProductCommentProps {
  review: productReviewInterface;
}

const ProductComment: React.FC<ProductCommentProps> = ({ review }) => {
  console.log(review, "review");
  return (
    <Box mb="32px" maxWidth="600px">
      <FlexBox alignItems="center" mb="1rem">
        {/* <Avatar src={review.user.} /> */}
        <Box ml="1rem">
          <H5 mb="4px">{review.customer.name}</H5>
          <FlexBox alignItems="center">
            <Rating value={review.rating} color="warn" readonly />
            <H6 mx="10px">{review.rating}</H6>
            <SemiSpan>{getDateDifference(review.created_at)}</SemiSpan>
          </FlexBox>
        </Box>
      </FlexBox>

      <Paragraph color="gray.700">{review.body}</Paragraph>
    </Box>
  );
};

export default ProductComment;
