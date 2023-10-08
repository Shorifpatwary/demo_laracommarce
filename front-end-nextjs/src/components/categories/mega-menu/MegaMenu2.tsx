import Card from "@component/Card";
import React, { useMemo } from "react";
import CategoryMenuItem from "../category-menu-item/CategoryMenuItem";
import MegaMenu3 from "./MegaMenu3";
import { StyledMegaMenu1 } from "./MegaMenuStyle";
import { CategoryInterface } from "interfaces/api-response";

export interface MegaMenu2Props {
  parent_id: number;
  categoriesState: CategoryInterface;
  hasChildWithParentId: (id: any) => boolean;
}

const MegaMenu2: React.FC<MegaMenu2Props> = ({
  parent_id,
  categoriesState,
  hasChildWithParentId,
}) => {
  // Define the getChild function
  const getChild = (item) => {
    return parent_id == item.parent_id;
  };
  // Use useMemo to memoize the filtered child categories
  const childCategories = useMemo(() => {
    return categoriesState?.filter(getChild);
  }, [categoriesState, parent_id]);

  return (
    <StyledMegaMenu1 className="mega-menu">
      <Card ml="1rem" py="0.5rem" boxShadow="regular">
        {childCategories?.map((item) => (
          <CategoryMenuItem
            title={item.name}
            href={item.slug}
            icon={item.icon}
            caret={hasChildWithParentId(item.id)}
            key={item.id}
          >
            {item.parent_id && (
              <MegaMenu3
                minWidth="560px"
                parent_id={item.id}
                categoriesState={categoriesState}
              />
            )}
          </CategoryMenuItem>
        ))}
      </Card>
    </StyledMegaMenu1>
  );
};

export default React.memo(MegaMenu2);
