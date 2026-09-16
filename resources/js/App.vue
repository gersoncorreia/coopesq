<template>
  <div class="min-h-screen flex flex-col justify-between">
    <div v-if="!isAdminRoute" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
      <TopBar />
      <Navbar />
    </div>
    <main class="flex-1">
      <router-view></router-view>
    </main>
    <Footer v-if="!isAdminRoute" />
  </div>
</template>

<script setup>
import { computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import TopBar from './Components/TopBar.vue';
import Navbar from './Components/Navbar.vue';
import Footer from './Components/Footer.vue';
import { useSettingsStore } from './stores/useSettingsStore';

const route = useRoute();
const settingsStore = useSettingsStore();

const isAdminRoute = computed(() => {
  return route.path.startsWith('/admin');
});

const updateFaviconAndTitle = () => {
  const faviconUrl = settingsStore.general.site_favicon;
  if (faviconUrl) {
    let link = document.querySelector("link[rel~='icon']");
    if (!link) {
      link = document.createElement('link');
      link.rel = 'icon';
      document.head.appendChild(link);
    }
    link.href = faviconUrl;
  }
};

watch(() => settingsStore.general.site_favicon, updateFaviconAndTitle);

onMounted(async () => {
  await settingsStore.fetchSettings();
  updateFaviconAndTitle();
});
</script>
