<template>
  <AdminLayout>
    <div class="space-y-5">
      <!-- Section Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-200/80">
        <div>
          <h1 class="text-xl font-bold tracking-tight text-zinc-900">Parceiros & Instituições</h1>
          <p class="text-xs text-zinc-500 mt-0.5">Instituições parceiras, órgãos apoiadores e clientes atendidos.</p>
        </div>
        <button 
          @click="openCreateModal"
          class="h-8 px-3 rounded-md text-xs font-medium bg-[#1B5E20] hover:bg-[#144718] text-white shadow-xs transition-colors inline-flex items-center gap-1.5 self-start cursor-pointer"
        >
          <Plus :size="14" />
          <span>Novo Parceiro</span>
        </button>
      </div>

      <div v-if="isLoading" class="p-12 text-center text-xs text-zinc-400 font-medium">
        Carregando parceiros...
      </div>

      <div v-else-if="partners.length === 0" class="p-12 text-center bg-white rounded-lg border border-zinc-200">
        <p class="text-zinc-400 text-xs">Nenhum parceiro cadastrado.</p>
      </div>

      <!-- Partners Grid with Pagination -->
      <div v-else class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div 
            v-for="partner in paginatedPartners" 
            :key="partner.id" 
            class="bg-white p-4 rounded-lg border border-zinc-200/80 shadow-xs flex flex-col justify-between space-y-3 hover:border-zinc-300 transition-colors"
          >
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded bg-zinc-100 border border-zinc-200 overflow-hidden shrink-0 flex items-center justify-center p-1">
                <img v-if="partner.logo" :src="partner.logo" :alt="partner.name" class="w-full h-full object-contain" />
                <Building2 v-else :size="16" class="text-zinc-400" />
              </div>
              <div>
                <h3 class="font-bold text-zinc-900 text-xs">{{ partner.name }}</h3>
                <a v-if="partner.url" :href="partner.url" target="_blank" class="text-[11px] text-[#1B5E20] hover:underline block truncate max-w-[120px]">
                  Link oficial ↗
                </a>
              </div>
            </div>

            <div class="pt-2.5 border-t border-zinc-100 flex items-center justify-between text-xs font-medium">
              <button @click="openEditModal(partner)" class="text-zinc-700 hover:text-zinc-950 transition-colors cursor-pointer">Editar</button>
              <button @click="deletePartner(partner.id)" class="text-rose-600 hover:text-rose-700 transition-colors cursor-pointer">Excluir</button>
            </div>
          </div>
        </div>

        <AdminPagination 
          :total="partners.length" 
          :per-page="perPage" 
          v-model:current-page="currentPage" 
        />
      </div>
    </div>

    <PartnerModal 
      v-if="isModalOpen" 
      :partner="selectedPartner" 
      @close="isModalOpen = false" 
      @saved="loadPartners" 
    />
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { Plus, Building2 } from 'lucide-vue-next';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import PartnerModal from '../../Components/Admin/Partners/PartnerModal.vue';
import AdminPagination from '../../Components/Admin/Common/AdminPagination.vue';

const partners = ref([]);
const isLoading = ref(true);
const isModalOpen = ref(false);
const selectedPartner = ref(null);
const currentPage = ref(1);
const perPage = 8;

const paginatedPartners = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return partners.value.slice(start, start + perPage);
});

const loadPartners = async () => {
  isLoading.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    const res = await axios.get('/api/admin/partners', {
      headers: { Authorization: `Bearer ${token}` }
    });
    partners.value = Array.isArray(res.data) ? res.data : (res.data.data || []);
  } catch (err) {
    console.error('Erro ao carregar parceiros:', err);
  } finally {
    isLoading.value = false;
  }
};

const openCreateModal = () => { selectedPartner.value = null; isModalOpen.value = true; };
const openEditModal = (partner) => { selectedPartner.value = { ...partner }; isModalOpen.value = true; };

const deletePartner = async (id) => {
  if (!confirm('Confirmar exclusão deste parceiro?')) return;
  const token = localStorage.getItem('admin_token');
  try {
    await axios.delete(`/api/admin/partners/${id}`, { headers: { Authorization: `Bearer ${token}` } });
    loadPartners();
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao excluir parceiro.');
  }
};

onMounted(loadPartners);
</script>
