<template>
  <div 
    class="bg-[#0b1c0e] text-slate-300 text-xs border-b border-white/5 px-6 sm:px-8 lg:px-12 hidden md:block select-none transition-all duration-300 overflow-hidden"
    :class="scrolled ? 'max-h-0 py-0 opacity-0 border-transparent' : 'max-h-12 py-2 opacity-100'"
  >
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <!-- Contact Info -->
      <div class="flex items-center gap-6">
        <a 
          :href="`tel:${settingsStore.contacts.phone_primary || '61995763665'}`" 
          class="flex items-center gap-1.5 hover:text-[#F5A623] transition-colors"
        >
          <Phone :size="12" class="text-[#F5A623]" />
          <span>{{ settingsStore.contacts.phone_primary || '(61) 99576-3665' }}</span>
        </a>
        <a 
          :href="`mailto:${settingsStore.contacts.email || 'coopesqcooperativa@gmail.com'}`" 
          class="flex items-center gap-1.5 hover:text-[#F5A623] transition-colors"
        >
          <Mail :size="12" class="text-[#F5A623]" />
          <span>{{ settingsStore.contacts.email || 'coopesqcooperativa@gmail.com' }}</span>
        </a>
        <div class="flex items-center gap-1.5 text-slate-400">
          <MapPin :size="12" class="text-emerald-500" />
          <span>{{ settingsStore.contacts.address || 'Porto Acre - AC, Brasil' }}</span>
        </div>
      </div>

      <!-- Quick Links / Hours -->
      <div class="flex items-center gap-4 text-[11px] text-slate-400">
        <span class="flex items-center gap-1">
          <Clock :size="12" class="text-emerald-500" />
          <span>Seg - Sex: 08:00 às 17:00</span>
        </span>
        <span class="text-white/10">|</span>
        <a 
          :href="settingsStore.socials.instagram_url || 'https://instagram.com/coopesq'" 
          target="_blank"
          class="hover:text-[#F5A623] transition-colors flex items-center gap-1 font-medium"
        >
          <span>Instagram</span>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Phone, Mail, MapPin, Clock } from 'lucide-vue-next';
import { useSettingsStore } from '../stores/useSettingsStore';

const settingsStore = useSettingsStore();
const scrolled = ref(false);

const handleScroll = () => {
  scrolled.value = window.scrollY > 40;
};

onMounted(() => window.addEventListener('scroll', handleScroll, { passive: true }));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>
