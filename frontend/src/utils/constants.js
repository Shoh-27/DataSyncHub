export const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';

export const APP_NAME = 'DataSyncHub';

export const ROUTES = {
  HOME: '/',
  LOGIN: '/login',
  REGISTER: '/register',
  DASHBOARD: '/dashboard',
  PROFILE: '/profile',
  WALLET: '/wallet',
  CHALLENGES: '/challenges',
  CHALLENGE_DETAIL: '/challenges/:id',
  LEADERBOARD: '/leaderboard',
};

