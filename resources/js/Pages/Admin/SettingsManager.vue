<template>
  <AdminLayout>
    <div class="space-y-6">
      <div class="flex justify-between items-center bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
          <h2 class="text-xl font-extrabold text-slate-900">Configurações Globais Whitelabel</h2>
          <p class="text-xs text-slate-500">Edite as informações institucionais, contatos e tags SEO do portal.</p>
        </div>
        <button 
          @click="saveSettings" 
          :disabled="saving"
          class="bg-coopesq-green hover:bg-coopesq-green-dark text-white font-bold px-6 py-2.5 rounded-xl shadow-md transition-all text-sm flex items-center gap-2 cursor-pointer"
        >
          {{ saving ? 'Salvando...' : '💾 Salvar Alterações' }}
        </button>
      </div>

      <div v-if="message" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-semibold">
        {{ message }}
      </div>

      <!-- Tabs por Grupo -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex border-b border-slate-200 bg-slate-50 px-6 pt-4 gap-4">
          <button 
            v-for="tab in ['general', 'contacts', 'socials', 'seo']" 
            :key="tab"
            @click="activeTab = tab"
            :class="[activeTab === tab ? 'border-coopesq-green text-coopesq-green font-bold bg-white' : 'border-transparent text-slate-500 hover:text-slate-700']"
            class="pb-3 px-4 border-b-2 text-sm uppercase tracking-wider transition-all cursor-pointer"
          >
            {{ tab === 'general' ? 'Geral / Marca' : tab === 'contacts' ? 'Contatos' : tab === 'socials' ? 'Redes Sociais' : 'SEO / Meta' }}
          </button>
        </div>

        <div class="p-8">
          <GeneralTab v-if="activeTab === 'general'" :form="form" />
          <ContactsTab v-if="activeTab === 'contacts'" :form="form" />
          <SocialsTab v-if="activeTab === 'socials'" :form="form" />
          <SeoTab v-if="activeTab === 'seo'" :form="form" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import GeneralTab from '../../Components/Admin/Settings/GeneralTab.vue';
import ContactsTab from '../../Components/Admin/Settings/ContactsTab.vue';
import SocialsTab from '../../Components/Admin/Settings/SocialsTab.vue';
import SeoTab from '../../Components/Admin/Settings/SeoTab.vue';

const activeTab = ref('general');
const saving = ref(false);
const message = ref('');

const form = ref({
  site_name: '', site_tagline: '', mission: '', vision: '', values: '',
  phone_primary: '', phone_secondary: '', phone_tertiary: '', email: '', address: '',
  instagram: '', instagram_url: '', meta_title: '', meta_description: '', meta_keywords: '',
});

const loadSettings = async () => {
  try {
    const res = await axios.get('/api/settings');
    const { general, contacts, socials, seo } = res.data;
    form.value = {
      ...form.value,
      ...(general || {}),
      ...(contacts || {}),
      ...(socials || {}),
      ...(seo || {}),
    };
  } catch (err) {
    console.error('Erro ao carregar settings:', err);
  }
};

const saveSettings = async () => {
  saving.value = true;
  message.value = '';
  const token = localStorage.getItem('admin_token');

  const settingsArray = [
    { key: 'site_name', value: form.value.site_name, group: 'general' },
    { key: 'site_tagline', value: form.value.site_tagline, group: 'general' },
    { key: 'mission', value: form.value.mission, group: 'general' },
    { key: 'vision', value: form.value.vision, group: 'general' },
    { key: 'values', value: form.value.values, group: 'general' },
    { key: 'phone_primary', value: form.value.phone_primary, group: 'contacts' },
    { key: 'phone_secondary', value: form.value.phone_secondary, group: 'contacts' },
    { key: 'phone_tertiary', value: form.value.phone_tertiary, group: 'contacts' },
    { key: 'email', value: form.value.email, group: 'contacts' },
    { key: 'address', value: form.value.address, group: 'contacts' },
    { key: 'instagram', value: form.value.instagram, group: 'socials' },
    { key: 'instagram_url', value: form.value.instagram_url, group: 'socials' },
    { key: 'meta_title', value: form.value.meta_title, group: 'seo' },
    { key: 'meta_description', value: form.value.meta_description, group: 'seo' },
    { key: 'meta_keywords', value: form.value.meta_keywords, group: 'seo' },
  ];

  try {
    await axios.post('/api/admin/settings', { settings: settingsArray }, {
      headers: { Authorization: `Bearer ${token}` }
    });
    message.value = 'Configurações whitelabel salvas com sucesso!';
  } catch (err) {
    console.error('Erro ao salvar settings:', err);
  } finally {
    saving.value = false;
  }
};

onMounted(() => {
  loadSettings();
});
</script>
