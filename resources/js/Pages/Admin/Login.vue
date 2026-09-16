<template>
  <div class="min-h-screen bg-[#071309] text-white flex flex-col justify-between relative overflow-hidden selection:bg-[#F5A623] selection:text-slate-950">
    <!-- Ambient Lighting Glows -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#1B5E20]/30 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-[#F5A623]/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-emerald-600/5 rounded-full blur-[140px] pointer-events-none"></div>

    <!-- Top Navigation Return Bar -->
    <header class="p-6 relative z-10">
      <router-link 
        to="/" 
        class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-200/70 hover:text-white transition-colors group cursor-pointer"
      >
        <ArrowLeft :size="15" class="group-hover:-translate-x-1 transition-transform" />
        <span>Voltar para o Portal Público</span>
      </router-link>
    </header>

    <!-- Main Card Container -->
    <main class="flex-1 flex items-center justify-center px-4 py-8 relative z-10">
      <div class="w-full max-w-md bg-slate-900/80 backdrop-blur-xl p-8 sm:p-10 rounded-3xl border border-white/10 shadow-2xl shadow-black/80 space-y-7">
        
        <!-- Header & Logo -->
        <div class="text-center space-y-3">
          <div class="flex justify-center mb-2">
            <img 
              v-if="settingsStore.general.site_logo || settingsStore.general.site_logo_header" 
              :src="settingsStore.general.site_logo || settingsStore.general.site_logo_header" 
              :alt="settingsStore.general.site_name || 'COOPESQ'" 
              class="h-14 sm:h-16 w-auto max-w-[200px] object-contain drop-shadow-md"
            />
            <div v-else class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#1B5E20] to-[#0f3813] border border-emerald-400/30 flex items-center justify-center text-[#F5A623] font-black text-2xl shadow-xl">
              C
            </div>
          </div>
          <div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight text-white uppercase">Acesso Restrito</h1>
            <p class="text-xs text-emerald-100/60 mt-1">Painel de Gestão & Governança da COOPESQ</p>
          </div>
        </div>

        <!-- Form -->
        <form @submit.prevent="handleLogin" class="space-y-4">
          <!-- Email Input -->
          <div class="space-y-1.5">
            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300">E-mail Corporativo</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <Mail :size="16" />
              </div>
              <input 
                v-model="email" 
                type="email" 
                required 
                autocomplete="email"
                placeholder="seu.email@coopesq.com.br"
                class="w-full pl-10 pr-4 py-2.5 bg-slate-950/60 border border-slate-700/80 rounded-xl text-white placeholder:text-slate-500 text-xs sm:text-sm focus:outline-none focus:border-[#F5A623] focus:ring-1 focus:ring-[#F5A623] transition-all"
              />
            </div>
          </div>

          <!-- Password Input with Toggle Visibility -->
          <div class="space-y-1.5">
            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300">Senha de Acesso</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <Lock :size="16" />
              </div>
              <input 
                v-model="password" 
                :type="showPassword ? 'text' : 'password'" 
                required 
                autocomplete="current-password"
                placeholder="••••••••••••"
                class="w-full pl-10 pr-10 py-2.5 bg-slate-950/60 border border-slate-700/80 rounded-xl text-white placeholder:text-slate-500 text-xs sm:text-sm focus:outline-none focus:border-[#F5A623] focus:ring-1 focus:ring-[#F5A623] transition-all"
              />
              <button 
                type="button" 
                @click="showPassword = !showPassword" 
                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-white cursor-pointer transition-colors"
                title="Mostrar/ocultar senha"
              >
                <EyeOff v-if="showPassword" :size="16" />
                <Eye v-else :size="16" />
              </button>
            </div>
          </div>

          <!-- Error Alert -->
          <div v-if="error" class="p-3 bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl text-xs flex items-center gap-2">
            <AlertCircle :size="15" class="shrink-0" />
            <span>{{ error }}</span>
          </div>

          <!-- Submit Button -->
          <button 
            type="submit" 
            :disabled="loading"
            class="w-full mt-2 bg-gradient-to-r from-[#1B5E20] via-[#227228] to-[#1B5E20] hover:from-[#227228] hover:to-[#1B5E20] text-white font-bold py-3 rounded-xl text-xs uppercase tracking-wider transition-all duration-200 shadow-lg shadow-black/40 hover:scale-[1.01] active:scale-[0.99] cursor-pointer disabled:opacity-50 flex items-center justify-center gap-2"
          >
            <Loader2 v-if="loading" :size="16" class="animate-spin" />
            <span>{{ loading ? 'Autenticando...' : 'Entrar no Sistema' }}</span>
          </button>
        </form>
      </div>
    </main>

    <!-- Footer Security Notice -->
    <footer class="p-6 text-center text-[11px] text-emerald-100/40 relative z-10 flex items-center justify-center gap-2">
      <ShieldCheck :size="14" class="text-[#F5A623]" />
      <span>Ambiente Protegido com Criptografia SSL • COOPESQ</span>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { Mail, Lock, Eye, EyeOff, ArrowLeft, ShieldCheck, Loader2, AlertCircle } from 'lucide-vue-next';
import { useSettingsStore } from '../../stores/useSettingsStore';

const router = useRouter();
const settingsStore = useSettingsStore();

const email = ref('');
const password = ref('');
const showPassword = ref(false);
const error = ref('');
const loading = ref(false);

const handleLogin = async () => {
  error.value = '';
  loading.value = true;
  try {
    const res = await axios.post('/api/admin/login', {
      email: email.value,
      password: password.value,
    });
    localStorage.setItem('admin_token', res.data.token);
    router.push('/admin');
  } catch (err) {
    error.value = err.response?.data?.message || 'Credenciais inválidas. Verifique seu e-mail e senha.';
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  if (!settingsStore.loaded) settingsStore.fetchSettings();
});
</script>
