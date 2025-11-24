import axios from './axios';

export const gamificationApi = {
  getStats: async () => {
    return await axios.get('/gamification/stats');
  },

  getBadges: async () => {
    return await axios.get('/gamification/badges');
  },

  getActivityFeed: async (limit = 50) => {
    return await axios.get('/gamification/activity-feed', {
      params: { limit },
    });
  },

  getLeaderboard: async (limit = 100) => {
    return await axios.get('/gamification/leaderboard', {
      params: { limit },
    });
  },

  getAllBadges: async (category = null, rarity = null) => {
    return await axios.get('/badges', {
      params: { category, rarity },
    });
  },
};