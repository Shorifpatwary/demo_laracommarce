import Icon from "@component/icon/Icon";
import NextImage from "next/image";
import React from "react";
import styled from "styled-components";
import FlexBox from "../FlexBox";
import Typography from "../Typography";

const StyledImage = styled(NextImage)`
  border-radius: 5px;
`;

export interface MobileCategoryImageBoxProps {
  name: string;
  image?: string;
  icon?: string;
}

const MobileCategoryImageBox: React.FC<MobileCategoryImageBoxProps> = ({
  name,
  image,
  icon,
}) => {
  return (
    <FlexBox flexDirection="column" alignItems="center" justifyContent="center">
      {image ? (
        <StyledImage src={image} objectFit="cover" width={100} height={80} />
      ) : (
        icon && <Icon size="48px">{icon}</Icon>
      )}
      <Typography
        className="ellipsis"
        textAlign="center"
        fontSize="11px"
        lineHeight="1"
        mt="0.5rem"
      >
        {name}
      </Typography>
    </FlexBox>
  );
};

export default React.memo(MobileCategoryImageBox);
