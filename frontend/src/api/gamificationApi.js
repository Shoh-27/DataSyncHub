import axios from './axios';

export const gamificationApi = {
  getStats: async () => {
    return await axios.get('/gamification/stats');
  },

  
};