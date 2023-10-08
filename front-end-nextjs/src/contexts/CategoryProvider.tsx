// CategoryContext.tsx
import {
  createContext,
  useContext,
  useState,
  useEffect,
  ReactNode,
  useMemo,
} from "react";
import useFetch from "@hook/useFetch";
import { category } from "@data/apis";
import { CategoryInterface } from "interfaces/api-response";
// interface Category {
//   id: number;
//   parent_id: number;
//   name: string;
//   slug: string;
//   image: string;
//   icon: string;
// }

interface CategoryContextType {
  categories: CategoryInterface[];
  parentCategories: CategoryInterface[];
  hasChildWithParentId: (id: number) => boolean;
  childCategories: (parentId: number) => CategoryInterface[];
}

const CategoryContext = createContext<CategoryContextType | undefined>(
  undefined
);

interface CategoryProviderProps {
  children: ReactNode;
}

export function useCategory() {
  const context = useContext(CategoryContext);
  if (context === undefined) {
    console.error("useCategory must be used within a CategoryProvider");
    // throw new Error("useCategory must be used within a CategoryProvider");
  }
  return context;
}

export function CategoryProvider({ children }: CategoryProviderProps) {
  const [categoriesState, setCategoriesState] = useState<CategoryInterface[]>();
  // Define the getParent function
  const getChilds = (item) => {
    return item.parent_id == null;
  };
  // Use useMemo to memoize the filtered parent categories
  const parentCategories = useMemo(() => {
    return categoriesState?.filter(getChilds);
  }, [categoriesState]);

  // return true if child category has on this category
  const hasChildWithParentId = (id) => {
    return categoriesState?.some((item) => item.parent_id === id);
  };

  // Define the getChild function
  const getChild = (item, parentId) => {
    return parentId === item.parent_id;
  };

  // Use useMemo to memoize the filtered child categories
  const childCategories = useMemo(() => {
    return (parentId) =>
      categoriesState?.filter((item) => getChild(item, parentId));
  }, [categoriesState]);

  // Call the useFetch hook to make the GET request for categories
  // if (!categoriesState) {
  var { data, error, isLoading, isComplete } = useFetch<CategoryInterface[]>(
    category.url, // Replace with the actual category URL
    category.method
  );
  // }

  useEffect(() => {
    // When the component mounts or when data changes, handle the response
    if (isComplete) {
      if (error) {
        // Handle the error
        console.error("Error:", error);
      } else {
        // Handle the data and set it in the context state
        setCategoriesState(data || []);
      }
    }
  }, [data, error, isComplete]);

  // Define the context value
  // const contextValue: CategoryContextType = {
  //   categories: categoriesState,
  //   parentCategories,
  //   hasChildWithParentId,
  //   childCategories,
  // };

  // Define the context value and memoize the categories
  const contextValue: CategoryContextType = useMemo(() => {
    return {
      categories: categoriesState,
      parentCategories,
      hasChildWithParentId,
      childCategories,
    };
  }, [categoriesState]);

  return (
    <CategoryContext.Provider value={contextValue}>
      {children}
    </CategoryContext.Provider>
  );
}
