import { defineStore } from 'pinia';
import axios from 'axios';

export const useSettingsStore = defineStore('settings', {
  state: () => ({
    general: {},
    contacts: {},
    socials: {},
    seo: {},
    loaded: false,
  }),
  actions: {
    async fetchSettings() {
      try {
        const response = await axios.get('/api/settings');
        this.general = response.data.general || {};
        this.contacts = response.data.contacts || {};
        this.socials = response.data.socials || {};
        this.seo = response.data.seo || {};
        this.loaded = true;
      } catch (error) {
        console.error('Erro ao carregar configurações whitelabel:', error);
      }
    },
  },
});
