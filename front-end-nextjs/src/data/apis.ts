import { HTTPMethod } from "@hook/useFetch";
// export type HTTPMethod = "GET" | "POST" | "PUT" | "DELETE";
export type argumentsType = {
  url: string;
  method: HTTPMethod;
  success_status_code: number;
  error_status_code?: number;
};

export const checkTokenValidity: argumentsType = {
  url: "http://localhost:8000/api/check-token",
  method: "POST",
  success_status_code: 200,
  error_status_code: 401,
};

export const login: argumentsType = {
  url: "http://localhost:8000/api/login",
  method: "POST",
  success_status_code: 200,
  error_status_code: 422,
};

export const register: argumentsType = {
  url: "http://localhost:8000/api/register",
  method: "POST",
  success_status_code: 200,
  error_status_code: 422,
};

export const customerProfile: argumentsType = {
  url: "http://localhost:8000/api/customer/profile",
  method: "GET",
  success_status_code: 200,
  error_status_code: 401,
};

export const editCP: argumentsType = {
  url: "http://localhost:8000/api/customer/edit",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};

export const updateCP: argumentsType = {
  url: "http://localhost:8000/api/customer/update",
  method: "PUT",
  success_status_code: 200,
  error_status_code: 422,
};

export const category: argumentsType = {
  url: "http://localhost:8000/api/category",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};

export const brand: argumentsType = {
  url: "http://localhost:8000/api/brand",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};

export const productSearch: argumentsType = {
  url: "http://localhost:8000/api/search",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};
// for home page
export const todayDeal: argumentsType = {
  url: "http://localhost:8000/api/today_deal",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};
export const newArrival: argumentsType = {
  url: "http://localhost:8000/api/new_arrival",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};
export const bestDiscount: argumentsType = {
  url: "http://localhost:8000/api/best_discount",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};
export const trendingItem: argumentsType = {
  url: "http://localhost:8000/api/trending",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};

export const subscriberCreate: argumentsType = {
  url: "http://localhost:8000/api/create_news_letter",
  method: "POST",
  success_status_code: 200,
  error_status_code: 422,
};

export const status = {
  success_status_code: 200,
  error_unauthorized: 401,
  error_forbidden: 403,
};

// Export the full object as the default export
export default {
  checkTokenValidity,
  login,
  register,
  customerProfile,
  editCP,
  updateCP,
  category,
  status,
};
