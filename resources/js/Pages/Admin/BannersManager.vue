<template>
  <AdminLayout>
    <div class="space-y-5">
      <!-- Section Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-200/80">
        <div>
          <h1 class="text-xl font-bold tracking-tight text-zinc-900">Banners Rotativos (Hero)</h1>
          <p class="text-xs text-zinc-500 mt-0.5">Gerencie os destaques visuais exibidos na página inicial.</p>
        </div>
        <button 
          @click="openCreateModal"
          class="h-8 px-3 rounded-md text-xs font-medium bg-[#1B5E20] hover:bg-[#144718] text-white shadow-xs transition-colors inline-flex items-center gap-1.5 self-start cursor-pointer"
        >
          <Plus :size="14" />
          <span>Novo Banner</span>
        </button>
      </div>

      <div v-if="isLoading" class="p-12 text-center text-xs text-zinc-400 font-medium">
        Carregando banners...
      </div>

      <div v-else-if="banners.length === 0" class="p-12 text-center bg-white rounded-lg border border-zinc-200">
        <p class="text-zinc-400 text-xs">Nenhum banner cadastrado.</p>
      </div>

      <!-- Banners Grid with Pagination -->
      <div v-else class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          <div 
            v-for="banner in paginatedBanners" 
            :key="banner.id"
            class="bg-white rounded-lg border border-zinc-200/80 overflow-hidden shadow-xs flex flex-col justify-between"
          >
            <div class="relative h-40 bg-zinc-100 border-b border-zinc-200/60">
              <img 
                :src="banner.image" 
                :alt="banner.title || 'Banner'"
                class="w-full h-full object-cover" 
              />
              <span 
                :class="banner.is_active ? 'bg-emerald-600 text-white' : 'bg-zinc-600 text-white'"
                class="absolute top-2.5 right-2.5 text-[10px] font-bold px-2 py-0.5 rounded shadow-xs uppercase tracking-wider"
              >
                {{ banner.is_active ? 'Ativo' : 'Inativo' }}
              </span>
            </div>

            <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
              <div>
                <span class="text-[10px] font-mono text-zinc-400 block mb-1">Posição / Ordem: {{ banner.order }}</span>
                <h3 class="font-bold text-zinc-900 text-xs line-clamp-1">{{ banner.title || '(Sem título definido)' }}</h3>
                <p class="text-xs text-zinc-500 line-clamp-2 mt-1 leading-relaxed">{{ banner.subtitle }}</p>
              </div>

              <div class="pt-3 border-t border-zinc-100 flex items-center justify-between text-xs font-medium">
                <button 
                  @click="openEditModal(banner)"
                  class="text-zinc-700 hover:text-zinc-950 font-semibold transition-colors cursor-pointer"
                >
                  Editar
                </button>
                <button 
                  @click="deleteBanner(banner.id)"
                  class="text-rose-600 hover:text-rose-700 font-semibold transition-colors cursor-pointer"
                >
                  Excluir
                </button>
              </div>
            </div>
          </div>
        </div>

        <AdminPagination 
          :total="banners.length" 
          :per-page="perPage" 
          v-model:current-page="currentPage" 
        />
      </div>
    </div>

    <BannerModal 
      v-if="isModalOpen" 
      :banner="selectedBanner" 
      @close="isModalOpen = false" 
      @saved="fetchBanners" 
    />
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { Plus } from 'lucide-vue-next';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import BannerModal from '../../Components/Admin/Banners/BannerModal.vue';
import AdminPagination from '../../Components/Admin/Common/AdminPagination.vue';

const banners = ref([]);
const isLoading = ref(true);
const isModalOpen = ref(false);
const selectedBanner = ref(null);
const currentPage = ref(1);
const perPage = 8;

const paginatedBanners = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return banners.value.slice(start, start + perPage);
});

const fetchBanners = async () => {
  isLoading.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    const res = await axios.get('/api/admin/banners', {
      headers: { Authorization: `Bearer ${token}` }
    });
    banners.value = Array.isArray(res.data) ? res.data : (res.data.data || []);
  } catch (err) {
    console.error('Erro ao buscar banners:', err);
  } finally {
    isLoading.value = false;
  }
};

const openCreateModal = () => { selectedBanner.value = null; isModalOpen.value = true; };
const openEditModal = (banner) => { selectedBanner.value = { ...banner }; isModalOpen.value = true; };

const deleteBanner = async (id) => {
  if (!confirm('Deseja realmente excluir este banner?')) return;
  const token = localStorage.getItem('admin_token');
  try {
    await axios.delete(`/api/admin/banners/${id}`, { headers: { Authorization: `Bearer ${token}` } });
    fetchBanners();
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao excluir banner.');
  }
};

onMounted(fetchBanners);
</script>
