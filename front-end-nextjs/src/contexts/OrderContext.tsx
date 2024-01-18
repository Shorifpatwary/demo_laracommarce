import { createContext, useContext, useMemo } from "react";

interface OrderProsessContextType {}

const OrderContext = createContext<OrderProsessContextType | undefined>(
  undefined
);

export function useCategory() {
  const context = useContext(OrderContext);
  if (context === undefined) {
    console.error("useCategory must be used within a OrderProvider");
  }
  return context;
}

export function OrderProvider({ children }) {
  // Define the context value and memoize the categories
  const contextValue = useMemo(() => {
    return {};
  }, []);

  return (
    <OrderContext.Provider value={contextValue}>
      {children}
    </OrderContext.Provider>
  );
}
