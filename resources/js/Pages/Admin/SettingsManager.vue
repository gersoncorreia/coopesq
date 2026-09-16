<template>
  <AdminLayout>
    <div class="space-y-5">
      <!-- Section Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-200/80">
        <div>
          <h1 class="text-xl font-bold tracking-tight text-zinc-900">Configurações Gerais</h1>
          <p class="text-xs text-zinc-500 mt-0.5">Parâmetros institucionais, missão, contatos e indexação para o portal público.</p>
        </div>
        <button 
          @click="saveSettings" 
          :disabled="saving"
          class="h-8 px-3.5 rounded-md text-xs font-medium bg-[#1B5E20] hover:bg-[#144718] text-white shadow-xs transition-colors inline-flex items-center gap-1.5 self-start cursor-pointer disabled:opacity-50"
        >
          <Save :size="14" />
          <span>{{ saving ? 'Salvando...' : 'Salvar Alterações' }}</span>
        </button>
      </div>

      <!-- Feedback Banner -->
      <div v-if="message" class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-md text-xs font-medium flex items-center gap-2">
        <CheckCircle2 :size="14" class="text-emerald-600" />
        <span>{{ message }}</span>
      </div>

      <!-- Settings Form Canvas -->
      <div class="bg-white rounded-lg border border-zinc-200/80 shadow-xs overflow-hidden">
        <!-- Modern Linear Tab Bar -->
        <div class="flex border-b border-zinc-200 px-4 sm:px-6 bg-zinc-50/50 gap-4 sm:gap-6 overflow-x-auto no-scrollbar">
          <button 
            v-for="tab in tabs" 
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[activeTab === tab.id ? 'border-[#1B5E20] text-zinc-900 font-bold' : 'border-transparent text-zinc-500 hover:text-zinc-800 font-medium']"
            class="py-3 border-b-2 text-xs transition-colors cursor-pointer flex items-center gap-2 whitespace-nowrap shrink-0"
          >
            <component :is="tab.icon" :size="14" :class="activeTab === tab.id ? 'text-[#1B5E20]' : 'text-zinc-400'" />
            <span>{{ tab.label }}</span>
          </button>
        </div>

        <div class="p-4 sm:p-6 md:p-8">
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
import { Save, CheckCircle2, Building, Phone, Share2, Search } from 'lucide-vue-next';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import GeneralTab from '../../Components/Admin/Settings/GeneralTab.vue';
import ContactsTab from '../../Components/Admin/Settings/ContactsTab.vue';
import SocialsTab from '../../Components/Admin/Settings/SocialsTab.vue';
import SeoTab from '../../Components/Admin/Settings/SeoTab.vue';

const activeTab = ref('general');
const saving = ref(false);
const message = ref('');

const tabs = [
  { id: 'general', label: 'Identidade & Missão', icon: Building },
  { id: 'contacts', label: 'Canais de Atendimento', icon: Phone },
  { id: 'socials', label: 'Redes Sociais', icon: Share2 },
  { id: 'seo', label: 'Indexação SEO', icon: Search },
];

const form = ref({
  site_name: '', site_tagline: '', site_logo_header: '', site_logo_footer: '', site_favicon: '', mission: '', vision: '', values: '',
  phone_primary: '', phone_secondary: '', phone_tertiary: '', email: '', address: '',
  instagram: '', instagram_url: '', meta_title: '', meta_description: '', meta_keywords: '',
});

const loadSettings = async () => {
  try {
    const res = await axios.get('/api/settings');
    const { general, contacts, socials, seo } = res.data;
    form.value = { ...form.value, ...(general || {}), ...(contacts || {}), ...(socials || {}), ...(seo || {}) };
  } catch (err) {
    console.error('Erro ao carregar settings:', err);
  }
};

const saveSettings = async () => {
  saving.value = true;
  message.value = '';
  const token = localStorage.getItem('admin_token');

  const settingsArray = [
    { key: 'site_name', value: form.value.site_name || '', group: 'general' },
    { key: 'site_tagline', value: form.value.site_tagline || '', group: 'general' },
    { key: 'site_logo_header', value: form.value.site_logo_header || '', group: 'general' },
    { key: 'site_logo_footer', value: form.value.site_logo_footer || '', group: 'general' },
    { key: 'site_logo', value: form.value.site_logo_header || '', group: 'general' },
    { key: 'site_favicon', value: form.value.site_favicon || '', group: 'general' },
    { key: 'about_image', value: form.value.about_image || '', group: 'general' },
    { key: 'mission', value: form.value.mission || '', group: 'general' },
    { key: 'vision', value: form.value.vision || '', group: 'general' },
    { key: 'values', value: form.value.values || '', group: 'general' },
    { key: 'phone_primary', value: form.value.phone_primary || '', group: 'contacts' },
    { key: 'phone_secondary', value: form.value.phone_secondary || '', group: 'contacts' },
    { key: 'phone_tertiary', value: form.value.phone_tertiary || '', group: 'contacts' },
    { key: 'email', value: form.value.email || '', group: 'contacts' },
    { key: 'address', value: form.value.address || '', group: 'contacts' },
    { key: 'instagram', value: form.value.instagram || '', group: 'socials' },
    { key: 'instagram_url', value: form.value.instagram_url || '', group: 'socials' },
    { key: 'meta_title', value: form.value.meta_title || '', group: 'seo' },
    { key: 'meta_description', value: form.value.meta_description || '', group: 'seo' },
    { key: 'meta_keywords', value: form.value.meta_keywords || '', group: 'seo' },
  ];

  try {
    await axios.post('/api/admin/settings', { settings: settingsArray }, {
      headers: { Authorization: `Bearer ${token}` }
    });
    message.value = 'Configurações atualizadas com sucesso!';
    setTimeout(() => { message.value = ''; }, 3500);
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao salvar configurações.');
  } finally {
    saving.value = false;
  }
};

onMounted(loadSettings);
</script>
