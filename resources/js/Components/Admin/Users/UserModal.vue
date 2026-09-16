<template>
  <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center pb-3 border-b border-slate-100">
        <h3 class="font-bold text-slate-800 text-lg">
          {{ user?.id ? 'Editar Usuário' : 'Novo Usuário' }}
        </h3>
        <button @click="$emit('close')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
      </div>


      <form @submit.prevent="handleSubmit" class="space-y-4 text-sm">
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nome Completo</label>
          <input 
            v-model="form.name" 
            type="text" 
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
            placeholder="Ex: Administrador Geral" 
            required
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">E-mail de Acesso</label>
          <input 
            v-model="form.email" 
            type="email" 
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
            placeholder="admin@coopesq.com" 
            required
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
            {{ user?.id ? 'Nova Senha (deixe em branco para manter a atual)' : 'Senha de Acesso (mín. 8 caracteres)' }}
          </label>
          <input 
            v-model="form.password" 
            type="password" 
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
            :required="!user?.id"
            placeholder="••••••••" 
          />
        </div>


        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Função / Permissão</label>
          <select 
            v-model="form.role" 
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"
          >
            <option value="admin">Administrador Geral</option>
            <option value="editor">Editor de Conteúdo</option>
          </select>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
          <button 
            type="button" 
            @click="$emit('close')" 
            class="px-4 py-2 border border-slate-300 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors"
          >
            Cancelar
          </button>
          <button 
            type="submit" 
            :disabled="isSaving" 
            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-colors disabled:opacity-50"
          >
            {{ isSaving ? 'Salvando...' : 'Salvar Usuário' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
  user: { type: Object, default: () => ({}) }
});

const emit = defineEmits(['close', 'saved']);
const isSaving = ref(false);

const form = reactive({
  name: '',
  email: '',
  password: '',
  role: 'editor'
});

onMounted(() => {
  if (props.user?.id) {
    form.name = props.user.name;
    form.email = props.user.email;
    form.role = props.user.role;
    form.password = '';
  }
});

const handleSubmit = async () => {
  isSaving.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    if (props.user?.id) {
      await axios.put(`/api/admin/users/${props.user.id}`, form, {
        headers: { Authorization: `Bearer ${token}` }
      });
    } else {
      await axios.post('/api/admin/users', form, {
        headers: { Authorization: `Bearer ${token}` }
      });
    }
    emit('saved');
    emit('close');
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao salvar usuário.');
  } finally {
    isSaving.value = false;
  }
};
</script>
