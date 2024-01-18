// Define action types
// const ADD_CART_ITEMS = "ADD_CART_ITEMS";
const SET_NOTE = "SET_NOTE";
const SET_SHIPPING_ADDRESS = "SET_SHIPPING_ADDRESS";
const SET_IS_BILLING_ADDRESS_SAME = "SET_IS_BILLING_ADDRESS_SAME";
const SET_BILLING_ADDRESS = "SET_BILLING_ADDRESS";
const SET_PAYMENT_METHOD = "SET_PAYMENT_METHOD";
const SET_PAYMENT_DETAILS = "SET_PAYMENT_DETAILS";
const CREATE_ORDER = "CREATE_ORDER";
const CLEAR_ORDER = "CLEAR_ORDER";
const SET_ERROR = "SET_ERROR";

// Define the initial state for the Order reducer
export const orderInitialState = {
  note: "",
  shippingAddress: {
    name: "",
    phoneNumber: "",
    postal_code: "",
    address: "",
    // email: "",
    // company: "",
    // country: "",
    // address2: "",
  },
  // SET_IS_BILLING_ADDRESS_SAME
  isBillingAddressSame: false,
  billingAddress: {
    name: "",
    phoneNumber: "",
    postal_code: "",
    address: "",
    // email: "",
    // company: "",
    // country: "",
    // address2: "",
  },
  paymentMethod: "cashOnDelivery", // 'creditCard', 'paypal', or 'cashOnDelivery'
  // paymentDetails: {
  //   cardNumber: "",
  //   expDate: "",
  //   nameOnCard: "",
  //   paypalEmail: "",
  // },
  errors: null,
};

// ts types
// Define a TypeScript interface for ShippingAddress
export interface ShippingAddress {
  name: string;
  phoneNumber: string;
  postal_code: string;
  address: string;
  // email: string;
  // company: string;
  // country: string;
  // address2: string;
}

// Define a TypeScript interface for BillingAddress
export interface BillingAddress {
  name: string;
  phoneNumber: string;
  postal_code: string;
  address: string;
  // email: string;
  // company: string;
  // country: string;
  // address2: string;
}

export interface PaymentDetails {
  paypalEmail: string;
}

// Define action types for the Order reducer
export type OrderActionType =
  | { type: typeof SET_SHIPPING_ADDRESS; payload: ShippingAddress }
  | { type: typeof SET_IS_BILLING_ADDRESS_SAME; payload: boolean }
  | { type: typeof SET_BILLING_ADDRESS; payload: BillingAddress }
  | {
      type: typeof SET_PAYMENT_METHOD;
      // "creditCard" |
      payload: "paypal" | "cashOnDelivery";
    }
  | { type: typeof SET_PAYMENT_DETAILS; payload: PaymentDetails }
  | { type: typeof SET_NOTE; payload: string }
  | { type: typeof CREATE_ORDER }
  | { type: typeof SET_ERROR; payload: {} }
  | { type: typeof CLEAR_ORDER };

// Define the reducer function for the Order reducer
export const orderReducer: React.Reducer<
  typeof orderInitialState,
  OrderActionType
> = (state: typeof orderInitialState, action: OrderActionType) => {
  switch (action.type) {
    case SET_NOTE:
      return { ...state, note: action.payload };

    case SET_PAYMENT_DETAILS:
      return { ...state, paymentDetails: action.payload };

    case SET_SHIPPING_ADDRESS:
      // Implement logic to set the shipping address
      return { ...state, shippingAddress: action.payload };
    case SET_IS_BILLING_ADDRESS_SAME:
      // Implement logic to set the billing address same
      return { ...state, isBillingAddressSame: action.payload };
    case SET_BILLING_ADDRESS:
      // Implement logic to set the billing address
      // return { ...state, billingAddress: action.payload };

      // Create a deep copy of billingAddress to avoid modifying the original state
      const updatedBillingAddress = {
        ...state.billingAddress,
        ...action.payload,
      };
      return { ...state, billingAddress: updatedBillingAddress };

    case SET_PAYMENT_METHOD:
      // Implement logic to set the payment method
      return { ...state, paymentMethod: action.payload };

    case CREATE_ORDER:
      // Implement logic to mark the order as created (if needed)
      return orderInitialState;

    case SET_ERROR:
      // Implement logic to mark the order as created (if needed)
      return { ...state, errors: action.payload };

    case CLEAR_ORDER:
      return orderInitialState;

    default:
      return state;
  }
};
