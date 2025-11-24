import axios from './axios';

export const challengeApi = {
  getChallenges: async (category = null, difficulty = null) => {
    return await axios.get('/challenges', {
      params: { category, difficulty },
    });
  },

  getChallenge: async id => {
    return await axios.get(`/challenges/${id}`);
  },

  submitChallenge: async data => {
    return await axios.post('/challenges/submit', data);
  },

  getMySubmissions: async (status = null) => {
    return await axios.get('/challenges/my-submissions', {
      params: { status },
    });
  },

  getMyStats: async () => {
    return await axios.get('/challenges/my-stats');
  },

  getPendingSubmissions: async (limit = 50) => {
    return await axios.get('/challenges/pending', {
      params: { limit },
    });
  },

  reviewSubmission: async (submissionId, data) => {
    return await axios.post(`/challenges/review/${submissionId}`, data);
  },
};