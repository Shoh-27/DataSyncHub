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

export const LEVELS = {
  newbie: { name: 'Newbie', xp: 0, color: 'var(--level-newbie)' },
  junior: { name: 'Junior', xp: 500, color: 'var(--level-junior)' },
  mid1: { name: 'Mid I', xp: 1500, color: 'var(--level-mid1)' },
  mid2: { name: 'Mid II', xp: 3500, color: 'var(--level-mid2)' },
  mid3: { name: 'Mid III', xp: 7000, color: 'var(--level-mid3)' },
  senior1: { name: 'Senior I', xp: 12000, color: 'var(--level-senior1)' },
  senior2: { name: 'Senior II', xp: 20000, color: 'var(--level-senior2)' },
};

export const BADGE_RARITY = {
  common: { name: 'Common', color: 'var(--rarity-common)' },
  rare: { name: 'Rare', color: 'var(--rarity-rare)' },
  epic: { name: 'Epic', color: 'var(--rarity-epic)' },
  legendary: { name: 'Legendary', color: 'var(--rarity-legendary)' },
};

export const CHALLENGE_CATEGORIES = {
  backend: { name: 'Backend', icon: '⚙️' },
  frontend: { name: 'Frontend', icon: '🎨' },
  devops: { name: 'DevOps', icon: '🚀' },
  algorithm: { name: 'Algorithm', icon: '🧮' },
};

export const CHALLENGE_DIFFICULTY = {
  small: { name: 'Small', xp: 20, color: 'var(--color-success)' },
  medium: { name: 'Medium', xp: 50, color: 'var(--color-warning)' },
  hard: { name: 'Hard', xp: 100, color: 'var(--color-error)' },
};

export const CONNECT_PACKAGES = [
  { id: 1, connects: 10, price: 5.0, bonus: 0 },
  { id: 2, connects: 50, price: 22.5, bonus: 5 },
  { id: 3, connects: 100, price: 40.0, bonus: 15 },
  { id: 4, connects: 250, price: 90.0, bonus: 50 },
];

