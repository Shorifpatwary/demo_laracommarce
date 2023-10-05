export const checkTokenValidity = {
  url: "http://localhost:8000/api/check-token",
  method: "POST",
  success_status_code: 200,
  error_status_code: 401,
};

export const login = {
  url: "http://localhost:8000/api/login",
  method: "POST",
  success_status_code: 200,
  error_status_code: 422,
};

export const register = {
  url: "http://localhost:8000/api/register",
  method: "POST",
  success_status_code: 200,
  error_status_code: 422,
};

export const customerProfile = {
  url: "http://localhost:8000/api/customer/profile",
  method: "GET",
  success_status_code: 200,
  error_status_code: 401,
};

export const editCP = {
  url: "http://localhost:8000/api/customer/edit",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};

export const updateCP = {
  url: "http://localhost:8000/api/customer/update",
  method: "PUT",
  success_status_code: 200,
  error_status_code: 422,
};

export const category = {
  url: "http://localhost:8000/api/category",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};

export const status = {
  success_status_code: 200,
  error_unauthorized: 401,
  error_forbidden: 403,
};

// Export all objects separately
// export {
//   checkTokenValidity,
//   login,
//   register,
//   customerProfile,
//   editCP,
//   updateCP,
//   category,
//   status,
// };

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
