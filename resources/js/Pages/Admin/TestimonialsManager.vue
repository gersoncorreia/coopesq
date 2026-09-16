<template>
  <AdminLayout>
    <div class="space-y-5">
      <!-- Section Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-200/80">
        <div>
          <h1 class="text-xl font-bold tracking-tight text-zinc-900">Depoimentos de Cooperados</h1>
          <p class="text-xs text-zinc-500 mt-0.5">Relatos e histórias de produtores da Amazônia exibidos no portal público.</p>
        </div>
        <button 
          @click="openCreateModal"
          class="h-8 px-3 rounded-md text-xs font-medium bg-[#1B5E20] hover:bg-[#144718] text-white shadow-xs transition-colors inline-flex items-center gap-1.5 self-start cursor-pointer"
        >
          <Plus :size="14" />
          <span>Novo Depoimento</span>
        </button>
      </div>

      <div v-if="isLoading" class="p-12 text-center text-xs text-zinc-400 font-medium">
        Carregando depoimentos...
      </div>

      <div v-else-if="testimonials.length === 0" class="p-12 text-center bg-white rounded-lg border border-zinc-200">
        <p class="text-zinc-400 text-xs">Nenhum depoimento cadastrado.</p>
      </div>

      <!-- Testimonials Grid with Pagination -->
      <div v-else class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          <div 
            v-for="item in paginatedTestimonials" 
            :key="item.id"
            class="bg-white rounded-lg border border-zinc-200/80 p-5 shadow-xs flex flex-col justify-between space-y-4 hover:border-zinc-300 transition-colors"
          >
            <div class="space-y-3">
              <div class="flex items-center gap-3">
                <img 
                  v-if="item.image" 
                  :src="item.image" 
                  :alt="item.name" 
                  class="w-10 h-10 rounded-md object-cover border border-zinc-200" 
                />
                <div v-else class="w-10 h-10 rounded-md bg-emerald-50 text-emerald-800 font-bold flex items-center justify-center text-sm border border-emerald-200/60">
                  {{ item.name.charAt(0) }}
                </div>
                <div>
                  <h3 class="font-bold text-zinc-900 text-xs">{{ item.name }}</h3>
                  <span class="text-[11px] text-[#1B5E20] font-semibold block">{{ item.role }}</span>
                </div>
              </div>

              <p class="text-xs text-zinc-600 italic bg-zinc-50 p-3 rounded-md border border-zinc-100 leading-relaxed">
                "{{ item.content }}"
              </p>
            </div>

            <div class="pt-3 border-t border-zinc-100 flex items-center justify-between text-xs font-medium">
              <span class="text-[10px] font-mono text-zinc-400">Ordem: {{ item.order }}</span>
              <div class="flex items-center gap-3">
                <button 
                  @click="openEditModal(item)"
                  class="text-zinc-700 hover:text-zinc-950 font-semibold transition-colors cursor-pointer"
                >
                  Editar
                </button>
                <button 
                  @click="deleteTestimonial(item.id)"
                  class="text-rose-600 hover:text-rose-700 transition-colors cursor-pointer"
                >
                  Excluir
                </button>
              </div>
            </div>
          </div>
        </div>

        <AdminPagination 
          :total="testimonials.length" 
          :per-page="perPage" 
          v-model:current-page="currentPage" 
        />
      </div>
    </div>

    <TestimonialModal 
      v-if="isModalOpen" 
      :testimonial="selectedTestimonial" 
      @close="isModalOpen = false" 
      @saved="fetchTestimonials" 
    />
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { Plus } from 'lucide-vue-next';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import TestimonialModal from '../../Components/Admin/Testimonials/TestimonialModal.vue';
import AdminPagination from '../../Components/Admin/Common/AdminPagination.vue';

const testimonials = ref([]);
const isLoading = ref(true);
const isModalOpen = ref(false);
const selectedTestimonial = ref(null);
const currentPage = ref(1);
const perPage = 8;

const paginatedTestimonials = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return testimonials.value.slice(start, start + perPage);
});

const fetchTestimonials = async () => {
  isLoading.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    const res = await axios.get('/api/admin/testimonials', {
      headers: { Authorization: `Bearer ${token}` }
    });
    testimonials.value = Array.isArray(res.data) ? res.data : (res.data.data || []);
  } catch (err) {
    console.error('Erro ao carregar depoimentos:', err);
  } finally {
    isLoading.value = false;
  }
};

const openCreateModal = () => { selectedTestimonial.value = null; isModalOpen.value = true; };
const openEditModal = (item) => { selectedTestimonial.value = { ...item }; isModalOpen.value = true; };

const deleteTestimonial = async (id) => {
  if (!confirm('Deseja excluir este depoimento?')) return;
  const token = localStorage.getItem('admin_token');
  try {
    await axios.delete(`/api/admin/testimonials/${id}`, { headers: { Authorization: `Bearer ${token}` } });
    fetchTestimonials();
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao excluir depoimento.');
  }
};

onMounted(fetchTestimonials);
</script>
