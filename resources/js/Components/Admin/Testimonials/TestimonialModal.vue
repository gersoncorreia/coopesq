<template>
  <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center pb-3 border-b border-slate-100">
        <h3 class="font-bold text-slate-800 text-lg">
          {{ testimonial?.id ? 'Editar Depoimento' : 'Novo Depoimento' }}
        </h3>
        <button @click="$emit('close')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
      </div>


      <form @submit.prevent="handleSubmit" class="space-y-4 text-sm">
        <ImageUploader v-model="form.image" label="Foto do Cooperado/Cliente" />

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nome Completo</label>
          <input 
            v-model="form.name" 
            type="text" 
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
            placeholder="Ex: João da Silva" 
            required
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cargo / Papel na Cooperativa</label>
          <input 
            v-model="form.role" 
            type="text" 
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
            placeholder="Ex: Produtor de Tambaqui / Cooperado" 
            required
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Depoimento / Relato</label>
          <textarea 
            v-model="form.content" 
            rows="3" 
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
            placeholder="Ex: A cooperativa transformou a realidade da minha produção familiar..."
            required
          ></textarea>
        </div>

        <div class="grid grid-cols-2 gap-3 items-center pt-2">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ordem</label>
            <input 
              v-model.number="form.order" 
              type="number" 
              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
            />
          </div>
          <div class="flex items-center gap-2 mt-4">
            <input 
              v-model="form.is_active" 
              type="checkbox" 
              id="test_active" 
              class="rounded text-emerald-600 focus:ring-emerald-500"
            />
            <label for="test_active" class="text-xs font-bold text-slate-700">Depoimento Ativo</label>
          </div>
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
            {{ isSaving ? 'Salvando...' : 'Salvar Depoimento' }}
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
  testimonial: { type: Object, default: () => ({}) }
});

const emit = defineEmits(['close', 'saved']);
const isSaving = ref(false);

const form = reactive({
  name: '',
  role: 'Cooperado',
  content: '',
  image: '',
  order: 0,
  is_active: true
});

const syncForm = () => {
  if (props.testimonial?.id) {
    Object.assign(form, props.testimonial);
  }
};

onMounted(syncForm);
watch(() => props.testimonial, syncForm, { deep: true });

const handleSubmit = async () => {
  isSaving.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    if (props.testimonial?.id) {
      await axios.put(`/api/admin/testimonials/${props.testimonial.id}`, form, {
        headers: { Authorization: `Bearer ${token}` }
      });
    } else {
      await axios.post('/api/admin/testimonials', form, {
        headers: { Authorization: `Bearer ${token}` }
      });
    }
    emit('saved');
    emit('close');
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao salvar depoimento.');
  } finally {
    isSaving.value = false;
  }
};
</script>
