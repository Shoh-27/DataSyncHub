import axios from './axios';

export const authApi = {
  register: async data => {
    return await axios.post('/auth/register', data);
  },

  login: async credentials => {
    return await axios.post('/auth/login', credentials);
  },

  logout: async () => {
    return await axios.post('/auth/logout');
  },

  getMe: async () => {
    return await axios.get('/auth/me');
  },

  resendVerification: async () => {
    return await axios.post('/auth/resend-verification');
  },

  verifyEmail: async token => {
    return await axios.post('/auth/verify-email', { token });
  },

  
};