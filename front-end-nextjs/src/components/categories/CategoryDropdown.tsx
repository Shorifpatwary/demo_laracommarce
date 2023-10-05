import navigations from "@data/navigations";
import React, { useEffect, useMemo, useState } from "react";
import CategoryMenuItem from "./category-menu-item/CategoryMenuItem";
import { StyledCategoryDropdown } from "./CategoryDropdownStyle";
import MegaMenu1 from "./mega-menu/MegaMenu1";
import MegaMenu2 from "./mega-menu/MegaMenu2";
import { H2 } from "@component/Typography";
import useFetch from "@hook/useFetch";

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
  // Replace 'yourApiUrl' with your actual API endpoint URL
  const apiUrl = "http://localhost:8000/api/category";

  // Call the useFetch hook to make the GET request
  const { data, error, isLoading, isComplete } = useFetch(apiUrl, "GET");

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

// make parent category box filtering parent_id null .
// pass parent id and full category array
// make sub category box filtering parent id value parent_id
// pass parent id and full category array
// make child category box filtering parent id value parent_id
// pass parent id and full category array

// Step 3: Use useEffect to make the fetch request
// useEffect(() => {
//   // Define the API URL
//   const apiUrl = "http://localhost:8000/api/category";

//   // Make the fetch request
//   fetch(apiUrl)
//     .then((response) => {
//       // Check if the response status code matches the success_status_code
//       if (response.status === 200) {
//         return response.json(); // Parse the JSON response
//       } else {
//         throw new Error("Fetch failed");
//       }
//     })
//     .then((data) => {
//       // Update the state with the fetched data
//       setCategoriesState(data.data);
//     })
//     .catch((error) => {
//       console.error("Fetch error:", error);
//     });
// }, []);
