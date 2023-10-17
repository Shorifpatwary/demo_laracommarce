import React from "react";
import Box from "../Box";
import Typography, { H3 } from "../Typography";

export interface ProductDescriptionProps {
  description: string;
}

const ProductDescription: React.FC<ProductDescriptionProps> = ({
  description,
}) => {
  return (
    <Box>
      <div dangerouslySetInnerHTML={{ __html: description }} />
    </Box>
  );
};

export default ProductDescription;
