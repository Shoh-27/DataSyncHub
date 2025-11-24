import axios from './axios';

export const walletApi = {
  getWallet: async () => {
    return await axios.get('/wallet');
  },

  getConnectHistory: async (limit = 50, offset = 0) => {
    return await axios.get('/wallet/connect-history', {
      params: { limit, offset },
    });
  },

  
};