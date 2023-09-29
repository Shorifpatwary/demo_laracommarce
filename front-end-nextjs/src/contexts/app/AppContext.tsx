import React, {
  createContext,
  useContext,
  useEffect,
  useMemo,
  useReducer,
} from "react";
// import { ContextDevTool } from "react-context-devtool";
import { categories } from "@data/apis";
import {
  initialState,
  rootActionType,
  rootReducer,
} from "../../reducers/rootReducer";
import useFetch from "@hook/useFetch";

const AppContext = createContext(null);

export const AppProvider: React.FC = ({ children }) => {
  const categoriesValue = useFetch(categories.url, "GET");

  const [state, dispatch] = useReducer(rootReducer, initialState);

  const contextValue = useMemo(() => {
    return { state, dispatch };
  }, [state, dispatch]);

  return (
    <AppContext.Provider value={{ contextValue, categories: categoriesValue }}>
      {/* <ContextDevTool context={AppContext} id="app-context" displayName="App" /> */}
      {children}
    </AppContext.Provider>
  );
};

export const useAppContext = () =>
  useContext<{
    state: typeof initialState;
    dispatch: (args: rootActionType) => void;
  }>(AppContext);

export default AppContext;
