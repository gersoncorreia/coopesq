<template>
  <div class="min-h-screen bg-slate-100 py-16 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl border border-slate-200">
      <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-full bg-coopesq-green text-coopesq-orange font-black text-2xl mx-auto flex items-center justify-center mb-4">
          C
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900">Área Restrita Admin</h2>
        <p class="text-xs text-slate-500 mt-1">Gerenciamento Whitelabel da COOPESQ</p>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-5">
        <div>
          <label class="block text-xs font-bold uppercase text-slate-700 mb-1">E-mail Corporativo</label>
          <input 
            v-model="email" 
            type="email" 
            required 
            placeholder="admin@coopesq.com.br"
            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-coopesq-green text-sm"
          />
        </div>

        <div>
          <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Senha</label>
          <input 
            v-model="password" 
            type="password" 
            required 
            placeholder="••••••••"
            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-coopesq-green text-sm"
          />
        </div>

        <div v-if="error" class="bg-red-50 text-red-600 text-xs p-3 rounded-lg border border-red-200">
          {{ error }}
        </div>

        <button 
          type="submit" 
          :disabled="loading"
          class="w-full bg-coopesq-green hover:bg-coopesq-green-dark text-white font-bold py-3 rounded-lg transition-all shadow-md text-sm"
        >
          {{ loading ? 'Autenticando...' : 'Entrar no Painel' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const email = ref('admin@coopesq.com.br');
const password = ref('password');
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
    error.value = err.response?.data?.message || 'E-mail ou senha incorretos.';
  } finally {
    loading.value = false;
  }
};
</script>
