<template>
  <div class="min-h-screen flex flex-col justify-between">
    <div v-if="!isAdminRoute" class="absolute top-0 left-0 right-0 z-50">
      <Navbar />
    </div>
    <main class="flex-1">
      <router-view></router-view>
    </main>
    <Footer v-if="!isAdminRoute" />
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import Navbar from './Components/Navbar.vue';
import Footer from './Components/Footer.vue';
import { useSettingsStore } from './stores/useSettingsStore';

const route = useRoute();
const settingsStore = useSettingsStore();

const isAdminRoute = computed(() => {
  return route.path.startsWith('/admin');
});

onMounted(() => {
  settingsStore.fetchSettings();
});
</script>
