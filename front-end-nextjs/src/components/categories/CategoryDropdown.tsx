import navigations from "@data/navigations";
import React, { useEffect, useMemo, useState } from "react";
import CategoryMenuItem from "./category-menu-item/CategoryMenuItem";
import { StyledCategoryDropdown } from "./CategoryDropdownStyle";
import MegaMenu1 from "./mega-menu/MegaMenu1";
import MegaMenu2 from "./mega-menu/MegaMenu2";
import { H2 } from "@component/Typography";
import useFetch from "@hook/useFetch";
import { category } from "@data/apis";

export interface CategoryDropdownProps {
  open: boolean;
  position?: "absolute" | "relative";
}

const CategoryDropdown: React.FC<CategoryDropdownProps> = ({
  open,
  position,
}) => {
  const megaMenu = {
    MegaMenu1,
    MegaMenu2,
  };
  const [categoriesState, setCategoriesState] = useState([]);
  const [hoveredCategory, setHoveredCategory] = useState(null);

  // Call the useFetch hook to make the GET request
  const { data, error, isLoading, isComplete } = useFetch(
    category.url,
    category.method as "GET"
  );

  useEffect(() => {
    // When the component mounts or when data changes, you can handle the response
    if (isComplete) {
      if (error) {
        // Handle the error
        console.error("Error:", error);
      } else {
        // Handle the data
        setCategoriesState(data);
      }
    }
  }, [data, error, isComplete]);

  // Define the getParent function
  const getParent = (item) => {
    return item.parent_id == null;
  };
  // Use useMemo to memoize the filtered parent categories
  const parentCategories = useMemo(() => {
    return categoriesState?.filter(getParent);
  }, [categoriesState]);

  const handleCategoryHover = (itemId) => {
    // Set the hoveredCategory state when a category is hovered
    setHoveredCategory(itemId);
  };

  const hasChildWithParentId = (id) => {
    return categoriesState?.some((item) => item.parent_id === id);
  };

  return (
    <StyledCategoryDropdown open={open} position={position}>
      {parentCategories?.map((item, index, arr) => {
        return (
          <div
            key={item.id}
            onMouseEnter={() => handleCategoryHover(item.id)} // Handle hover event
            onMouseLeave={() => setHoveredCategory(null)} // Handle mouse leave event
          >
            <CategoryMenuItem
              title={item.name}
              href={item.slug}
              icon={item.icon}
              caret={hasChildWithParentId(item.id)}
              key={item.id}
            >
              {hoveredCategory === item.id && (
                <MegaMenu2
                  parent_id={item.id}
                  categoriesState={categoriesState}
                  // data={item.menuData || {}}
                  hasChildWithParentId={hasChildWithParentId}
                />
              )}
            </CategoryMenuItem>
          </div>
        );
      })}
    </StyledCategoryDropdown>
  );
};

CategoryDropdown.defaultProps = {
  position: "absolute",
};

// export default CategoryDropdown;
export default React.memo(CategoryDropdown);

// if (isLoading) {
//   return (
//     <StyledCategoryDropdown open={open} position={position}>
//       <div className="animate-pulse ">
//         <div className="bg-black text-white	 h-100 w-200 border">Loading</div>
//         <div className="bg-black text-white	 h-100 w-200 border">Loading</div>
//         <div className="bg-black text-white	 h-100 w-200 border">Loading</div>
//       </div>
//     </StyledCategoryDropdown>
//   );
// }
// @keyframes pulse {
//   0%, 100% {
//     opacity: 1;
//   }
//   50% {
//     opacity: 0.5;
//   }
// }

// .animate-pulse {
//   animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
// }
