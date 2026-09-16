<template>
  <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto border border-slate-100">
      <div class="flex justify-between items-center pb-3 border-b border-slate-100">
        <h3 class="font-black text-slate-800 text-lg font-display">
          {{ post?.id ? 'Editar Matéria' : 'Nova Matéria / Notícia' }}
        </h3>
        <button @click="$emit('close')" class="text-slate-400 hover:text-slate-600 font-bold p-1">✕</button>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4 text-sm">
        <ImageUploader v-model="form.featured_image" label="Imagem de Capa da Matéria" />

        <div>
          <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1">Título da Matéria</label>
          <input 
            v-model="form.title" 
            type="text" 
            required 
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-amber-500 focus:outline-none" 
            placeholder="Ex: Cooperativa COOPESQ amplia produção de tambaqui"
          />
        </div>

        <div>
          <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1">Resumo / Subtítulo (Excerpt)</label>
          <textarea 
            v-model="form.excerpt" 
            rows="2" 
            class="w-full p-3 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-amber-500 focus:outline-none" 
            placeholder="Breve resumo exibido nos cards da página inicial e redes..."
          ></textarea>
        </div>

        <div>
          <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1">Conteúdo Completo (HTML / Texto)</label>
          <textarea 
            v-model="form.content" 
            rows="5" 
            required 
            class="w-full p-3 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-amber-500 focus:outline-none font-mono" 
            placeholder="Escreva a notícia completa..."
          ></textarea>
        </div>

        <div class="flex items-center gap-2 pt-1">
          <input 
            v-model="form.is_published" 
            type="checkbox" 
            id="post_published" 
            class="rounded text-amber-500 focus:ring-amber-500"
          />
          <label for="post_published" class="text-xs font-bold text-slate-700">Publicar Imediatamente no Blog</label>
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
            class="px-5 py-2 bg-linear-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 rounded-xl text-xs font-bold transition-all disabled:opacity-50 shadow-md shadow-amber-500/20"
          >
            {{ isSaving ? 'Salvando...' : 'Salvar Matéria' }}
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
  post: { type: Object, default: null }
});

const emit = defineEmits(['close', 'saved']);
const isSaving = ref(false);

const form = reactive({
  title: '',
  excerpt: '',
  content: '',
  featured_image: '',
  category_id: 5,
  is_published: true
});

const syncForm = () => {
  if (props.post?.id) {
    Object.assign(form, props.post);
  }
};

onMounted(syncForm);
watch(() => props.post, syncForm, { deep: true });

const handleSubmit = async () => {
  isSaving.value = true;
  const token = localStorage.getItem('admin_token');
  const slug = form.title.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');

  try {
    if (props.post?.id) {
      await axios.put(`/api/admin/posts/${props.post.id}`, { ...form, slug }, {
        headers: { Authorization: `Bearer ${token}` }
      });
    } else {
      await axios.post('/api/admin/posts', { ...form, slug, published_at: new Date().toISOString() }, {
        headers: { Authorization: `Bearer ${token}` }
      });
    }
    emit('saved');
    emit('close');
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao salvar matéria.');
  } finally {
    isSaving.value = false;
  }
};
</script>
