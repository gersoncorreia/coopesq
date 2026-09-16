<template>
  <AdminLayout>
    <div class="space-y-5">
      <!-- Section Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-200/80">
        <div>
          <h1 class="text-xl font-bold tracking-tight text-zinc-900">Páginas Estáticas</h1>
          <p class="text-xs text-zinc-500 mt-0.5">Gerenciamento de páginas institucionais com suporte a SEO.</p>
        </div>
        <button 
          @click="openCreateModal"
          class="h-8 px-3 rounded-md text-xs font-medium bg-[#1B5E20] hover:bg-[#144718] text-white shadow-xs transition-colors inline-flex items-center gap-1.5 self-start cursor-pointer"
        >
          <Plus :size="14" />
          <span>Nova Página</span>
        </button>
      </div>

      <div v-if="isLoading" class="p-12 text-center text-xs text-zinc-400 font-medium">
        Carregando páginas...
      </div>

      <div v-else-if="pages.length === 0" class="p-12 text-center bg-white rounded-lg border border-zinc-200">
        <p class="text-zinc-400 text-xs">Nenhuma página cadastrada.</p>
      </div>

      <!-- Table Layout with Responsive Horizontal Scroll & Pagination -->
      <div v-else class="space-y-3">
        <div class="bg-white rounded-lg border border-zinc-200/80 shadow-xs overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left text-xs min-w-[500px]">
              <thead class="bg-zinc-50/80 border-b border-zinc-200/70 text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
                <tr>
                  <th class="py-3 px-4">Título</th>
                  <th class="py-3 px-4">Slug / Caminho</th>
                  <th class="py-3 px-4">Status</th>
                  <th class="py-3 px-4">Ordem</th>
                  <th class="py-3 px-4 text-right">Ações</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-zinc-100">
                <tr v-for="page in paginatedPages" :key="page.id" class="hover:bg-zinc-50/50 transition-colors">
                  <td class="py-3 px-4 font-semibold text-zinc-900">{{ page.title }}</td>
                  <td class="py-3 px-4 text-zinc-500 font-mono text-[11px]">/{{ page.slug }}</td>
                  <td class="py-3 px-4">
                    <span 
                      :class="page.is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-zinc-100 text-zinc-600 border-zinc-200'"
                      class="text-[10px] font-medium px-2 py-0.5 rounded border"
                    >
                      {{ page.is_active ? 'Ativa' : 'Inativa' }}
                    </span>
                  </td>
                  <td class="py-3 px-4 text-zinc-500 font-mono">{{ page.order }}</td>
                  <td class="py-3 px-4 text-right space-x-3">
                    <button @click="openEditModal(page)" class="font-medium text-zinc-700 hover:text-zinc-950 transition-colors cursor-pointer">
                      Editar
                    </button>
                    <button @click="deletePage(page.id)" class="font-medium text-rose-600 hover:text-rose-700 transition-colors cursor-pointer">
                      Excluir
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <AdminPagination 
          :total="pages.length" 
          :per-page="perPage" 
          v-model:current-page="currentPage" 
        />
      </div>
    </div>

    <PageModal 
      v-if="isModalOpen" 
      :page="selectedPage" 
      @close="isModalOpen = false" 
      @saved="fetchPages" 
    />
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { Plus } from 'lucide-vue-next';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import PageModal from '../../Components/Admin/Pages/PageModal.vue';
import AdminPagination from '../../Components/Admin/Common/AdminPagination.vue';

const pages = ref([]);
const isLoading = ref(true);
const isModalOpen = ref(false);
const selectedPage = ref(null);
const currentPage = ref(1);
const perPage = 8;

const paginatedPages = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return pages.value.slice(start, start + perPage);
});

const fetchPages = async () => {
  isLoading.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    const res = await axios.get('/api/admin/pages', {
      headers: { Authorization: `Bearer ${token}` }
    });
    pages.value = Array.isArray(res.data) ? res.data : (res.data.data || []);
  } catch (err) {
    console.error('Erro ao carregar páginas:', err);
  } finally {
    isLoading.value = false;
  }
};

const openCreateModal = () => { selectedPage.value = null; isModalOpen.value = true; };
const openEditModal = (page) => { selectedPage.value = { ...page }; isModalOpen.value = true; };

const deletePage = async (id) => {
  if (!confirm('Deseja realmente excluir esta página?')) return;
  const token = localStorage.getItem('admin_token');
  try {
    await axios.delete(`/api/admin/pages/${id}`, { headers: { Authorization: `Bearer ${token}` } });
    fetchPages();
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao excluir página.');
  }
};

onMounted(fetchPages);
</script>
