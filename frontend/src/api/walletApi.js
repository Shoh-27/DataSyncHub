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

  getConnectPackages: async () => {
    return await axios.get('/connect-packages');
  },

  createConnectPurchase: async packageId => {
    return await axios.post('/payments/connect-purchase', { package_id: packageId });
  },

  confirmConnectPurchase: async paymentIntentId => {
    return await axios.post('/payments/confirm-purchase', {
      payment_intent_id: paymentIntentId,
    });
  },

  getPaymentHistory: async (type = null, limit = 50) => {
    return await axios.get('/payments/history', {
      params: { type, limit },
    });
  },

 
};