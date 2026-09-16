<template>
  <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center pb-3 border-b border-slate-100">
        <h3 class="font-bold text-slate-800 text-lg">
          {{ banner?.id ? 'Editar Banner Hero' : 'Novo Banner Hero' }}
        </h3>
        <button @click="$emit('close')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4 text-sm">
        <ImageUploader v-model="form.image" label="Imagem do Banner (Hero)" />

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Título Principal</label>
          <input v-model="form.title" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="Ex: Piscicultura Sustentável na Amazônia" required />
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Subtítulo / Descrição</label>
          <textarea v-model="form.subtitle" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="Ex: Fortalecendo pequenos e médios produtores..."></textarea>
        </div>

        <!-- Opção de Habilitar Botão de Ação -->
        <div class="border border-slate-200 rounded-xl p-3.5 bg-slate-50/70 space-y-3">
          <div class="flex items-center justify-between">
            <div>
              <label for="enable_button" class="text-xs font-bold text-slate-800 block cursor-pointer">Habilitar botão de ação no banner</label>
              <span class="text-[11px] text-slate-400">Ative se desejar exibir um botão de chamada (CTA) sobre o banner</span>
            </div>
            <input 
              v-model="hasButton" 
              type="checkbox" 
              id="enable_button" 
              class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 cursor-pointer" 
            />
          </div>

          <div v-if="hasButton" class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-200/80">
            <div>
              <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Texto do Botão</label>
              <input v-model="form.cta_text" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="Ex: Conhecer Produtos" />
            </div>
            <div>
              <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Link de Destino</label>
              <input v-model="form.cta_url" type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="Ex: #produtos ou https://..." />
            </div>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3 items-center pt-2">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ordem</label>
            <input v-model.number="form.order" type="number" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
          </div>
          <div class="flex items-center gap-2 mt-4">
            <input v-model="form.is_active" type="checkbox" id="banner_active" class="rounded text-emerald-600 focus:ring-emerald-500" />
            <label for="banner_active" class="text-xs font-bold text-slate-700">Banner Ativo</label>
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
            {{ isSaving ? 'Salvando...' : 'Salvar Banner' }}
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
  banner: { type: Object, default: () => ({}) }
});

const emit = defineEmits(['close', 'saved']);
const isSaving = ref(false);
const hasButton = ref(false);

const form = reactive({
  title: '',
  subtitle: '',
  image: '',
  cta_text: '',
  cta_url: '',
  order: 0,
  is_active: true
});

const syncForm = () => {
  if (props.banner?.id) {
    Object.assign(form, props.banner);
    hasButton.value = Boolean(props.banner.cta_text && props.banner.cta_text.trim());
  } else {
    hasButton.value = false;
  }
};

onMounted(syncForm);
watch(() => props.banner, syncForm, { deep: true });

const handleSubmit = async () => {
  if (!form.image) {
    alert('Por favor, informe ou envie a imagem do banner.');
    return;
  }

  if (!hasButton.value) {
    form.cta_text = null;
    form.cta_url = null;
  }

  isSaving.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    if (props.banner?.id) {
      await axios.put(`/api/admin/banners/${props.banner.id}`, form, {
        headers: { Authorization: `Bearer ${token}` }
      });
    } else {
      await axios.post('/api/admin/banners', form, {
        headers: { Authorization: `Bearer ${token}` }
      });
    }
    emit('saved');
    emit('close');
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao salvar banner.');
  } finally {
    isSaving.value = false;
  }
};
</script>
