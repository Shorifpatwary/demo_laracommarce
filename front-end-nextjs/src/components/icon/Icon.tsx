import React, { ButtonHTMLAttributes } from "react";
import { SpaceProps } from "styled-system";
import { colorOptions } from "../../interfaces";
import StyledIcon from "./IconStyle";

export interface IconProps {
  size?: string;
  children: string;
  transform?: string;
  variant?: "small" | "medium" | "large";
  color?: colorOptions;
  defaultcolor?: "currentColor" | "auto";
}

const Icon: React.FC<
  IconProps & SpaceProps & ButtonHTMLAttributes<IconProps>
> = ({ children, ...props }: IconProps) => {
  // Regular expression to check if the 'children' prop contains an SVG tag
  const svgRegex = /<svg\s+/i;

  // Check if the 'children' prop contains an SVG tag using the regular expression
  const isSvgIcon = svgRegex.test(children.toString());

  // console.log(isSvgIcon, "is svg icon");
  // return <div> lsdkf l</div>;

  // If it's an SVG icon, use dangerouslySetInnerHTML on 'children'
  if (isSvgIcon) {
    const src = <div dangerouslySetInnerHTML={{ __html: children }} />;
    return (
      <StyledIcon
        src={src}
        {...props}
        fallback={() => <div dangerouslySetInnerHTML={{ __html: children }} />}
      />
    );
  }

  // Construct the 'src' value based on whether it's an SVG icon or not
  const src = `/assets/images/icons/${children}.svg`;

  return (
    <StyledIcon
      src={src}
      fallback={() => <span>{children?.trim()}</span>}
      {...props}
    />
  );
};

Icon.defaultProps = {
  variant: "medium",
  defaultcolor: "currentColor",
};

export default React.memo(Icon);
