import Cookies from "js-cookie";

console.log(Cookies, "cookies ");

// Define action type
const CHANGE_CART_AMOUNT = "CHANGE_CART_AMOUNT";
const CLEAR_CART = "CLEAR_CART";
// Retrieve the cart data from cookies
const cartData = Cookies.get("cartData");
const initialCartList = cartData ? JSON.parse(cartData) : [];

export const cartInitialState = {
  cartList: initialCartList,
};

// Define the cart state type
export type CartItem = {
  id: string | number;
  name: string;
  qty: number;
  price: number;
  imgUrl?: string;
};

export type CartStateType = {
  cartList: CartItem[];
};

export type CartActionType =
  | {
      type: typeof CHANGE_CART_AMOUNT;
      payload: CartItem;
    }
  | {
      type: typeof CLEAR_CART;
    };

export const cartReducer: React.Reducer<CartStateType, CartActionType> = (
  state: CartStateType,
  action: CartActionType
) => {
  switch (action.type) {
    case CHANGE_CART_AMOUNT:
      let cartList = state.cartList;
      let cartItem = action.payload;
      let exist = cartList.find((item) => item.id === cartItem.id);

      if (cartItem.qty < 1) {
        // Remove the item from the cart
        const updatedCartList = cartList.filter(
          (item) => item.id !== cartItem.id
        );
        Cookies.set("cartData", JSON.stringify(updatedCartList));
        return {
          cartList: cartList.filter((item) => item.id !== cartItem.id),
        };
      } else if (exist) {
        // Update the quantity of an existing item
        const updatedCartList = cartList.map((item) => {
          if (item.id === cartItem.id) return { ...item, qty: cartItem.qty };
          else return item;
        });
        Cookies.set("cartData", JSON.stringify(updatedCartList));
        return {
          cartList: updatedCartList,
        };
      } else {
        // Add a new item to the cart
        const newCartList = [...cartList, cartItem];
        Cookies.set("cartData", JSON.stringify(newCartList));
        return {
          cartList: newCartList,
        };
      }
    // cart clear
    case CLEAR_CART:
      Cookies.remove("cartData");
      return {
        cartList: [],
      };

    default: {
      return state;
    }
  }
};
