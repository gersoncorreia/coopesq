<template>
  <div class="min-h-screen bg-slate-100 flex">
    <!-- Sidebar Admin Persistente -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between hidden md:flex shrink-0">
      <div>
        <div class="p-6 border-b border-slate-800 flex items-center space-x-3">
          <div class="w-10 h-10 rounded-full bg-coopesq-orange text-slate-900 font-extrabold flex items-center justify-center">
            C
          </div>
          <div>
            <span class="font-extrabold text-lg text-white block">COOPESQ</span>
            <span class="text-xs text-slate-400">Painel Whitelabel</span>
          </div>
        </div>

        <nav class="p-4 space-y-1 text-sm font-medium">
          <router-link 
            to="/admin" 
            end
            active-class="bg-coopesq-green text-white font-bold"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 transition-colors"
          >
            📊 Dashboard Stats
          </router-link>

          <router-link 
            to="/admin/settings" 
            active-class="bg-coopesq-green text-white font-bold"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 transition-colors"
          >
            ⚙️ Configurações Site
          </router-link>

          <router-link 
            to="/admin/products" 
            active-class="bg-coopesq-green text-white font-bold"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 transition-colors"
          >
            🐟 Catálogo Produtos
          </router-link>

          <router-link 
            to="/admin/posts" 
            active-class="bg-coopesq-green text-white font-bold"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 transition-colors"
          >
            📰 Matérias / Blog
          </router-link>

          <router-link 
            to="/admin/partners" 
            active-class="bg-coopesq-green text-white font-bold"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 transition-colors"
          >
            🤝 Parceiros & Logos
          </router-link>
        </nav>
      </div>

      <div class="p-4 border-t border-slate-800">
        <button @click="logout" class="w-full text-left flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs text-red-400 hover:bg-red-500/10 font-bold transition-colors">
          🚪 Sair da Sessão
        </button>
      </div>
    </aside>

    <!-- Área Principal de Conteúdo -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
          <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Área de Administração</span>
        </div>
        <router-link to="/" target="_blank" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-4 py-2 rounded-lg text-xs transition-colors flex items-center gap-2">
          🌐 Ver Portal Público ↗
        </router-link>
      </header>

      <main class="flex-1 p-8 overflow-y-auto">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const logout = () => {
  localStorage.removeItem('admin_token');
  router.push('/admin/login');
};
</script>
