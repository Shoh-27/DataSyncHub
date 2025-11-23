
import axios from 'axios';
import { API_BASE_URL, STORAGE_KEYS } from '../utils/constants';

const axiosInstance = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
  timeout: 30000,
});

// Request interceptor
axiosInstance.interceptors.request.use(
  config => {
    const token = localStorage.getItem(STORAGE_KEYS.AUTH_TOKEN);
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

// Response interceptor
axiosInstance.interceptors.response.use(
  response => {
    return response.data;
  },
  error => {
    if (error.response) {
      // Handle specific error codes
      if (error.response.status === 401) {
        // Unauthorized - clear auth and redirect to login
        localStorage.removeItem(STORAGE_KEYS.AUTH_TOKEN);
        localStorage.removeItem(STORAGE_KEYS.USER);
        window.location.href = '/login';
      }

      // Return formatted error
      return Promise.reject({
        message: error.response.data.message || 'An error occurred',
        status: error.response.status,
        errors: error.response.data.errors || {},
      });
    }

    if (error.request) {
      // Network error
      return Promise.reject({
        message: 'Network error. Please check your connection.',
        status: 0,
      });
    }

    return Promise.reject({
      message: error.message || 'An unexpected error occurred',
      status: 0,
    });
  }
);

export default axiosInstance;