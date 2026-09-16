<template>
  <aside class="w-64 bg-[#0f172a] text-slate-200 border-r border-slate-800 flex flex-col justify-between shrink-0 z-30 select-none h-full">
    <div>
      <!-- Brand Header -->
      <div class="h-14 px-5 border-b border-slate-800/80 bg-slate-950/40 flex items-center justify-between">
        <router-link to="/admin" @click="$emit('close')" class="flex items-center gap-2.5">
          <img 
            v-if="settingsStore.general.site_logo"
            :src="settingsStore.general.site_logo" 
            :alt="settingsStore.general.site_name || 'COOPESQ'" 
            class="h-7 w-auto max-w-[110px] object-contain"
          />
          <div v-else class="flex items-center gap-2">
            <div class="w-7 h-7 rounded bg-[#1B5E20] flex items-center justify-center text-white font-bold text-xs shadow-sm">CQ</div>
            <span class="font-bold text-xs text-white">{{ settingsStore.general.site_name || 'COOPESQ' }}</span>
          </div>
        </router-link>
        <button @click="$emit('close')" class="md:hidden p-1 rounded text-slate-400 hover:text-white hover:bg-slate-800 cursor-pointer" title="Fechar menu">✕</button>
      </div>

      <!-- Navigation Menu Loop -->
      <div class="p-3 space-y-4 overflow-y-auto max-h-[calc(100vh-7.5rem)]">
        <div v-for="section in menuSections" :key="section.title">
          <span class="px-2 text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">{{ section.title }}</span>
          <div class="space-y-0.5">
            <router-link 
              v-for="item in section.items"
              :key="item.to"
              :to="item.to" 
              :end="item.exact"
              @click="$emit('close')"
              active-class="bg-[#1B5E20] text-white font-semibold shadow-xs"
              class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-xs text-slate-300 hover:text-white hover:bg-slate-800/60 transition-colors"
            >
              <component :is="item.icon" :size="15" class="text-slate-400" />
              <span>{{ item.label }}</span>
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- User & Session Footer -->
    <div class="p-3 border-t border-slate-800 bg-slate-950/50 flex items-center justify-between shrink-0">
      <div class="flex items-center gap-2">
        <div class="w-7 h-7 rounded bg-[#1B5E20]/40 text-emerald-300 font-bold flex items-center justify-center text-xs border border-emerald-500/30">AD</div>
        <div class="leading-tight">
          <span class="text-xs font-semibold text-slate-200 block">Administrador</span>
          <span class="text-[10px] text-emerald-400 font-mono">Conectado</span>
        </div>
      </div>
      <button @click="logout" title="Sair da conta" class="p-1.5 rounded text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 transition-colors cursor-pointer">
        <LogOut :size="15" />
      </button>
    </div>
  </aside>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { 
  LayoutDashboard, Settings, Package, FileText, Images, 
  MessageSquareQuote, Building2, Files, Users, LogOut 
} from 'lucide-vue-next';
import { useSettingsStore } from '../../stores/useSettingsStore';

defineEmits(['close']);
const router = useRouter();
const settingsStore = useSettingsStore();

const menuSections = [
  {
    title: 'Geral',
    items: [
      { label: 'Painel Principal', to: '/admin', exact: true, icon: LayoutDashboard },
      { label: 'Configurações', to: '/admin/settings', icon: Settings },
    ]
  },
  {
    title: 'Conteúdo & Catálogo',
    items: [
      { label: 'Produtos', to: '/admin/products', icon: Package },
      { label: 'Publicações', to: '/admin/posts', icon: FileText },
      { label: 'Banners', to: '/admin/banners', icon: Images },
      { label: 'Depoimentos', to: '/admin/testimonials', icon: MessageSquareQuote },
      { label: 'Parceiros', to: '/admin/partners', icon: Building2 },
    ]
  },
  {
    title: 'Sistema',
    items: [
      { label: 'Páginas Estáticas', to: '/admin/pages', icon: Files },
      { label: 'Usuários', to: '/admin/users', icon: Users },
    ]
  }
];

const logout = () => {
  localStorage.removeItem('admin_token');
  router.push('/admin/login');
};
</script>
