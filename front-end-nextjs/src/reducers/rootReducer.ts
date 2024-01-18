import { CartActionType, cartInitialState, cartReducer } from "./cartReducer";
import combineReducers from "./combineReducers";
import {
  layoutActionType,
  layoutInitialState,
  layoutReducer,
} from "./layoutReducer";
import {
  orderInitialState,
  orderReducer,
  OrderActionType,
} from "./orderReducer";

export type rootActionType =
  | layoutActionType
  | CartActionType
  | OrderActionType;

export const initialState = {
  layout: layoutInitialState,
  cart: cartInitialState,
  order: orderInitialState,
};

export const rootReducer = combineReducers({
  layout: layoutReducer,
  cart: cartReducer,
  order: orderReducer,
});
