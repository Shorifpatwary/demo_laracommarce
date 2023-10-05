// checkTokenValidity.js
export const checkTokenValidity = {
  url: "http://localhost:8000/api/check-token",
  method: "POST",
  success_status_code: 200,
  error_status_code: 401,
};

// login.js
export const login = {
  url: "http://localhost:8000/api/login",
  method: "POST",
  success_status_code: 200,
  error_status_code: 422,
};

// register.js
export const register = {
  url: "http://localhost:8000/api/register",
  method: "POST",
  success_status_code: 200,
  error_status_code: 422,
};

// customerProfile.js
export const customerProfile = {
  url: "http://localhost:8000/api/customer/profile",
  method: "GET",
  success_status_code: 200,
  error_status_code: 401,
};

// editCP.js
export const editCP = {
  url: "http://localhost:8000/api/customer/edit",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};

// updateCP.js
export const updateCP = {
  url: "http://localhost:8000/api/customer/update",
  method: "PUT",
  success_status_code: 200,
  error_status_code: 422,
};

// categories.js
export const categories = {
  url: "http://localhost:8000/api/categories",
  method: "GET",
  success_status_code: 200,
  error_status_code: 422,
};

// status.js
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
//   categories,
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
  categories,
  status,
};