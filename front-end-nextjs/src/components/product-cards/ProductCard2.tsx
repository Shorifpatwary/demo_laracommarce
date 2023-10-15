import HoverBox from "@component/HoverBox";
import { H4 } from "@component/Typography";
import { ProductInterface } from "interfaces/api-response";
import NextImage from "next/image";
import Link from "next/link";
import React from "react";

// export interface ProductCard2Props {
//   imgUrl: string;
//   title: string;
//   price: number;
//   productUrl: string;
// }
export interface ProductCard2Props {
  product: ProductInterface;
}

const ProductCard2: React.FC<ProductCard2Props> = ({ product }) => {
  return (
    <Link href={`/product/${product.id}`}>
      <a>
        <HoverBox borderRadius={8} mb="0.5rem">
          <NextImage
            src={product.thumbnail_link}
            width={100}
            height={100}
            layout="responsive"
            alt={product.name}
            blurDataURL="/assets/images/products/macbook.png"
            placeholder="blur"
            unoptimized // Disable optimization for this image
          />
        </HoverBox>
        <H4 fontWeight="600" fontSize="14px" mb="0.25rem">
          {product.name}
        </H4>
        <H4 fontWeight="600" fontSize="14px" color="primary.main">
          {product.selling_price}
        </H4>
      </a>
    </Link>
  );
};

export default ProductCard2;
