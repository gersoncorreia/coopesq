<template>
  <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto border border-slate-100">
      <div class="flex justify-between items-center pb-3 border-b border-slate-100">
        <h3 class="font-black text-slate-800 text-lg font-display">
          {{ partner?.id ? 'Editar Parceiro' : 'Cadastrar Parceiro' }}
        </h3>
        <button @click="$emit('close')" class="text-slate-400 hover:text-slate-600 font-bold p-1">✕</button>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4 text-sm">
        <ImageUploader v-model="form.logo" label="Logomarca da Instituição" />

        <div>
          <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1">Nome do Parceiro / Cliente</label>
          <input 
            v-model="form.name" 
            type="text" 
            required 
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
            placeholder="Ex: SEBRAE Acre"
          />
        </div>

        <div>
          <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1">Link Institucional (URL)</label>
          <input 
            v-model="form.url" 
            type="url" 
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
            placeholder="https://..."
          />
        </div>

        <div class="flex items-center gap-2 pt-1">
          <input 
            v-model="form.is_active" 
            type="checkbox" 
            id="partner_active" 
            class="rounded text-emerald-600 focus:ring-emerald-500"
          />
          <label for="partner_active" class="text-xs font-bold text-slate-700">Parceiro Ativo na Grade</label>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
          <button 
            type="button" 
            @click="$emit('close')" 
            class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors"
          >
            Cancelar
          </button>
          <button 
            type="submit" 
            :disabled="isSaving" 
            class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all disabled:opacity-50"
          >
            {{ isSaving ? 'Salvando...' : 'Salvar Parceiro' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
import axios from 'axios';
import ImageUploader from '../Common/ImageUploader.vue';

const props = defineProps({
  partner: { type: Object, default: null }
});

const emit = defineEmits(['close', 'saved']);
const isSaving = ref(false);

const form = reactive({
  name: '',
  url: '',
  logo: '',
  order: 0,
  is_active: true
});

const syncForm = () => {
  if (props.partner?.id) {
    Object.assign(form, props.partner);
  }
};

onMounted(syncForm);
watch(() => props.partner, syncForm, { deep: true });

const handleSubmit = async () => {
  isSaving.value = true;
  const token = localStorage.getItem('admin_token');

  try {
    if (props.partner?.id) {
      await axios.put(`/api/admin/partners/${props.partner.id}`, form, {
        headers: { Authorization: `Bearer ${token}` }
      });
    } else {
      await axios.post('/api/admin/partners', form, {
        headers: { Authorization: `Bearer ${token}` }
      });
    }
    emit('saved');
    emit('close');
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao salvar parceiro.');
  } finally {
    isSaving.value = false;
  }
};
</script>
