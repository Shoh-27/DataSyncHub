import axios from './axios';

export const walletApi = {
  getWallet: async () => {
    return await axios.get('/wallet');
  },

  
};