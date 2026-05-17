import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,
    userName: (state) => state.user?.name || '',
    userRole: (state) => state.user?.role || '',
  },
  actions: {
    async login(email, password) {
      try {
        const response = await api.post('/login', { email, password });
        this.token = response.data.access_token;
        this.user = response.data.user;
        localStorage.setItem('token', this.token);
      } catch (error) {
        console.error('Login failed:', error);
        throw error;
      }
    },
    async register(name, email, password, passwordConfirmation) {
      try {
        const response = await api.post('/register', {
          name,
          email,
          password,
          password_confirmation: passwordConfirmation,
        });
        return response.data;
      } catch (error) {
        console.error('Register failed:', error);
        throw error;
      }
    },
    async fetchUser() {
      if (!this.token) return;
      try {
        const response = await api.get('/me');
        this.user = response.data;
      } catch (error) {
        console.error('Failed to fetch user:', error);
        this.logout();
      }
    },
    logout() {
      this.token = null;
      this.user = null;
      localStorage.removeItem('token');
    },
  },
});
