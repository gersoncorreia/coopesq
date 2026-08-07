<template>
  <AdminLayout>
    <div class="space-y-6">
      <div class="flex justify-between items-center bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
          <h2 class="text-xl font-extrabold text-slate-900">Matérias e Publicações</h2>
          <p class="text-xs text-slate-500">Gerencie as notícias e conteúdos publicados no Blog da COOPESQ.</p>
        </div>
        <button 
          @click="showModal = true" 
          class="bg-coopesq-orange hover:bg-coopesq-orange-dark text-slate-900 font-bold px-5 py-2.5 rounded-xl shadow-md transition-all text-sm flex items-center gap-2"
        >
          ➕ Nova Matéria
        </button>
      </div>

      <!-- Lista de Posts -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div v-for="post in posts" :key="post.id" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
          <div>
            <span class="text-xs font-bold text-coopesq-orange uppercase tracking-wider block mb-1">
              {{ post.category ? post.category.name : 'Informativo' }}
            </span>
            <h3 class="font-bold text-slate-900 text-base mb-2">{{ post.title }}</h3>
            <p class="text-slate-500 text-xs line-clamp-3 mb-4 leading-relaxed">{{ post.excerpt }}</p>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-slate-100 text-xs">
            <span class="text-slate-400">👁️ {{ post.views || 0 }} visualizações</span>
            <button @click="deletePost(post.id)" class="text-red-600 hover:underline font-bold">Excluir</button>
          </div>
        </div>
      </div>

      <!-- Modal Modal Criar Post -->
      <div v-if="showModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-6 max-w-lg w-full shadow-2xl border border-slate-200">
          <h3 class="text-lg font-bold text-slate-900 mb-4">Cadastrar Nova Matéria</h3>
          <form @submit.prevent="createPost" class="space-y-4">
            <div>
              <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Título da Matéria</label>
              <input v-model="newPost.title" type="text" required class="w-full p-2.5 rounded-lg border border-slate-300 text-sm" />
            </div>
            <div>
              <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Resumo (Excerpt)</label>
              <textarea v-model="newPost.excerpt" rows="2" class="w-full p-2.5 rounded-lg border border-slate-300 text-sm"></textarea>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Conteúdo Completo (HTML)</label>
              <textarea v-model="newPost.content" rows="4" required class="w-full p-2.5 rounded-lg border border-slate-300 text-sm font-mono"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-4">
              <button type="button" @click="showModal = false" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-lg">Cancelar</button>
              <button type="submit" class="px-5 py-2 text-xs font-bold bg-coopesq-orange text-slate-900 rounded-lg shadow-sm">Publicar Matéria</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AdminLayout from '../../Layouts/AdminLayout.vue';

const posts = ref([]);
const showModal = ref(false);
const newPost = ref({
  title: '',
  excerpt: '',
  content: '',
});

const loadPosts = async () => {
  try {
    const res = await axios.get('/api/posts');
    posts.value = res.data.data || [];
  } catch (err) {
    console.error('Erro ao carregar posts:', err);
  }
};

const createPost = async () => {
  const token = localStorage.getItem('admin_token');
  const slug = newPost.value.title.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');

  try {
    await axios.post('/api/admin/posts', {
      ...newPost.value,
      slug: slug,
      category_id: 5,
      is_published: true,
      published_at: new Date().toISOString().slice(0, 19).replace('T', ' '),
    }, {
      headers: { Authorization: `Bearer ${token}` }
    });
    showModal.value = false;
    newPost.value = { title: '', excerpt: '', content: '' };
    loadPosts();
  } catch (err) {
    console.error('Erro ao criar post:', err);
  }
};

const deletePost = async (id) => {
  if (!confirm('Deseja excluir esta matéria?')) return;
  const token = localStorage.getItem('admin_token');
  try {
    await axios.delete(`/api/admin/posts/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    });
    loadPosts();
  } catch (err) {
    console.error('Erro ao excluir post:', err);
  }
};

onMounted(() => {
  loadPosts();
});
</script>
