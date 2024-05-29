// tokenHelper.js
import { useStore } from 'vuex';

export function getToken() {
  return useStore().state.token;
}
