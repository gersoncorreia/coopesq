<template>
  <AdminLayout>
    <div class="space-y-5">
      <!-- Section Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-200/80">
        <div>
          <h1 class="text-xl font-bold tracking-tight text-zinc-900">Matérias & Notícias</h1>
          <p class="text-xs text-zinc-500 mt-0.5">Artigos, informativos e comunicados oficiais no Blog da COOPESQ.</p>
        </div>
        <button 
          @click="openCreateModal"
          class="h-8 px-3 rounded-md text-xs font-medium bg-[#1B5E20] hover:bg-[#144718] text-white shadow-xs transition-colors inline-flex items-center gap-1.5 self-start cursor-pointer"
        >
          <Plus :size="14" />
          <span>Nova Matéria</span>
        </button>
      </div>

      <div v-if="isLoading" class="p-12 text-center text-xs text-zinc-400 font-medium">
        Carregando matérias...
      </div>

      <div v-else-if="posts.length === 0" class="p-12 text-center bg-white rounded-lg border border-zinc-200">
        <p class="text-zinc-400 text-xs">Nenhuma matéria publicada.</p>
      </div>

      <!-- Posts Grid with Pagination -->
      <div v-else class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div 
            v-for="post in paginatedPosts" 
            :key="post.id" 
            class="bg-white rounded-lg border border-zinc-200/80 p-5 shadow-xs flex flex-col justify-between space-y-4 hover:border-zinc-300 transition-colors"
          >
            <div class="space-y-2.5">
              <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200/60">
                  {{ post.category ? post.category.name : 'Informativo' }}
                </span>
                <span 
                  :class="post.is_published ? 'text-emerald-700 bg-emerald-50 border-emerald-200' : 'text-zinc-600 bg-zinc-100 border-zinc-200'"
                  class="text-[10px] font-medium px-2 py-0.5 rounded border"
                >
                  {{ post.is_published ? 'Publicado' : 'Rascunho' }}
                </span>
              </div>

              <h3 class="font-bold text-zinc-900 text-sm line-clamp-2 leading-snug">{{ post.title }}</h3>
              <p class="text-zinc-500 text-xs line-clamp-3 leading-relaxed">{{ post.excerpt || 'Sem resumo disponível.' }}</p>
            </div>

            <div class="flex items-center justify-between pt-3 border-t border-zinc-100 text-xs font-medium">
              <span class="text-zinc-400 text-[11px] font-mono flex items-center gap-1">
                <Eye :size="12" />
                <span>{{ post.views || 0 }} leituras</span>
              </span>
              <div class="flex items-center gap-3">
                <button @click="openEditModal(post)" class="text-zinc-700 hover:text-zinc-950 font-semibold transition-colors cursor-pointer">Editar</button>
                <button @click="deletePost(post.id)" class="text-rose-600 hover:text-rose-700 transition-colors cursor-pointer">Excluir</button>
              </div>
            </div>
          </div>
        </div>

        <AdminPagination 
          :total="posts.length" 
          :per-page="perPage" 
          v-model:current-page="currentPage" 
        />
      </div>
    </div>

    <PostModal 
      v-if="isModalOpen" 
      :post="selectedPost" 
      @close="isModalOpen = false" 
      @saved="loadPosts" 
    />
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { Plus, Eye } from 'lucide-vue-next';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import PostModal from '../../Components/Admin/Posts/PostModal.vue';
import AdminPagination from '../../Components/Admin/Common/AdminPagination.vue';

const posts = ref([]);
const isLoading = ref(true);
const isModalOpen = ref(false);
const selectedPost = ref(null);
const currentPage = ref(1);
const perPage = 8;

const paginatedPosts = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return posts.value.slice(start, start + perPage);
});

const loadPosts = async () => {
  isLoading.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    const res = await axios.get('/api/admin/posts', {
      headers: { Authorization: `Bearer ${token}` }
    });
    posts.value = Array.isArray(res.data) ? res.data : (res.data.data || []);
  } catch (err) {
    console.error('Erro ao carregar posts:', err);
  } finally {
    isLoading.value = false;
  }
};

const openCreateModal = () => { selectedPost.value = null; isModalOpen.value = true; };
const openEditModal = (post) => { selectedPost.value = { ...post }; isModalOpen.value = true; };

const deletePost = async (id) => {
  if (!confirm('Confirmar exclusão desta matéria?')) return;
  const token = localStorage.getItem('admin_token');
  try {
    await axios.delete(`/api/admin/posts/${id}`, { headers: { Authorization: `Bearer ${token}` } });
    loadPosts();
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao excluir matéria.');
  }
};

onMounted(loadPosts);
</script>
