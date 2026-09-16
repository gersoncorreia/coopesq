<template>
  <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center pb-3 border-b border-slate-100">
        <h3 class="font-bold text-slate-800 text-lg">
          {{ page?.id ? 'Editar Página' : 'Nova Página Institucional' }}
        </h3>
        <button @click="$emit('close')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
      </div>


      <form @submit.prevent="handleSubmit" class="space-y-4 text-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Título da Página</label>
            <input 
              v-model="form.title" 
              @input="generateSlug"
              type="text" 
              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
              placeholder="Ex: Estatuto Social" 
              required
            />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Slug (URL amigável)</label>
            <input 
              v-model="form.slug" 
              type="text" 
              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-slate-50" 
              placeholder="ex: estatuto-social" 
              required
            />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Conteúdo da Página</label>
          <textarea 
            v-model="form.content" 
            rows="6" 
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none font-mono" 
            placeholder="Digite o conteúdo da página..."
            required
          ></textarea>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Meta Description (SEO)</label>
          <input 
            v-model="form.meta_description" 
            type="text" 
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
            placeholder="Resumo da página para buscadores do Google" 
          />
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
              id="page_active" 
              class="rounded text-emerald-600 focus:ring-emerald-500"
            />
            <label for="page_active" class="text-xs font-bold text-slate-700">Página Ativa</label>
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
            {{ isSaving ? 'Salvando...' : 'Salvar Página' }}
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
  page: { type: Object, default: null }
});


const emit = defineEmits(['close', 'saved']);
const isSaving = ref(false);

const form = reactive({
  title: '',
  slug: '',
  content: '',
  meta_description: '',
  order: 0,
  is_active: true
});

onMounted(() => {
  if (props.page?.id) {
    Object.assign(form, props.page);
  }
});

const generateSlug = () => {
  if (!props.page?.id && form.title) {
    form.slug = form.title
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/(^-|-$)+/g, '');
  }
};

const handleSubmit = async () => {
  isSaving.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    if (props.page?.id) {
      await axios.put(`/api/admin/pages/${props.page.id}`, form, {
        headers: { Authorization: `Bearer ${token}` }
      });
    } else {
      await axios.post('/api/admin/pages', form, {
        headers: { Authorization: `Bearer ${token}` }
      });
    }
    emit('saved');
    emit('close');
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao salvar página.');
  } finally {
    isSaving.value = false;
  }
};
</script>
