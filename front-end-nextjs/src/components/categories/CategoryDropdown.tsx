import navigations from "@data/navigations";
import React, { useEffect, useState } from "react";
import CategoryMenuItem from "./category-menu-item/CategoryMenuItem";
import { StyledCategoryDropdown } from "./CategoryDropdownStyle";
import MegaMenu1 from "./mega-menu/MegaMenu1";
import MegaMenu2 from "./mega-menu/MegaMenu2";
import { useAppContext } from "@context/app/AppContext";
import { Span } from "@component/Typography";
import useFetch from "@hook/useFetch";
import { categories } from "@data/apis";
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

  // Step 3: Use useEffect to make the fetch request
  useEffect(() => {
    // Define the API URL
    const apiUrl = "http://localhost:8000/api/categories";

    // Make the fetch request
    fetch(apiUrl)
      .then((response) => {
        // Check if the response status code matches the success_status_code
        if (response.status === 200) {
          return response.json(); // Parse the JSON response
        } else {
          throw new Error("Fetch failed");
        }
      })
      .then((data) => {
        // Update the state with the fetched data
        setCategoriesState(data);
      })
      .catch((error) => {
        console.error("Fetch error:", error);
      });
  }, []);

  return (
    <StyledCategoryDropdown open={open} position={position}>
      {/* {categoriesValue.isLoading ? <Span> Loading </Span> : " "} */}

      {categoriesState.data?.map((item) => {
        let MegaMenu = megaMenu[item.menuComponent];

        return (
          <CategoryMenuItem
            title={item.title}
            href={item.href}
            icon={item.icon}
            caret={!!item.menuData}
            key={item.title}
          >
            <MegaMenu data={item.menuData || {}} />
          </CategoryMenuItem>
        );
      })}
    </StyledCategoryDropdown>
  );
};

CategoryDropdown.defaultProps = {
  position: "absolute",
};

export default CategoryDropdown;
