import { createStore } from 'vuex';
import axios from 'axios';
import router from '../../resources/js/routes'; 
export default createStore({
  state: {
    user: null,
    token: localStorage.getItem('token') || ''
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    setToken(state, token) {
      state.token = token;
      localStorage.setItem('token', token);
    },
    logout(state) {
      state.user = null;
      state.token = '';
      localStorage.removeItem('token');
    }
  },
  actions: {
    async login({ commit }, credentials) {
      const response = await axios.post('/api/login', credentials);
      commit('setUser', response.data.user);
      commit('setToken', response.data.token);
      axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
    },
    async logout({ commit }) {
      commit('logout');
      delete axios.defaults.headers.common['Authorization'];
      router.push('/admin-panel/login');

    },
    async fetchUser({ commit }) {
      if (this.state.token) {
        try {
          const response = await axios.get('/api/user');
          commit('setUser', response.data);
        } catch (error) {
          commit('logout');
        }
      }
    }
  },
  getters: {
    isAuthenticated: state => !!state.token,
    user: state => state.user
  }
});
