<template>
  <AdminLayout>
    <div class="space-y-5">
      <!-- Section Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-200/80">
        <div>
          <h1 class="text-xl font-bold tracking-tight text-zinc-900">Catálogo de Produtos</h1>
          <p class="text-xs text-zinc-500 mt-0.5">Gerenciamento de itens comercializados pela cooperativa.</p>
        </div>
        <button 
          @click="openCreateModal"
          class="h-8 px-3 rounded-md text-xs font-medium bg-[#1B5E20] hover:bg-[#144718] text-white shadow-xs transition-colors inline-flex items-center gap-1.5 self-start cursor-pointer"
        >
          <Plus :size="14" />
          <span>Novo Produto</span>
        </button>
      </div>

      <div v-if="isLoading" class="p-12 text-center text-xs text-zinc-400 font-medium">
        Carregando catálogo...
      </div>

      <div v-else-if="products.length === 0" class="p-12 text-center bg-white rounded-lg border border-zinc-200">
        <p class="text-zinc-400 text-xs">Nenhum produto cadastrado.</p>
      </div>

      <!-- Data Table with Responsive Horizontal Scroll & Pagination -->
      <div v-else class="space-y-3">
        <div class="bg-white rounded-lg border border-zinc-200/80 shadow-xs overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse min-w-[540px]">
              <thead class="bg-zinc-50/80 border-b border-zinc-200/70 text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
                <tr>
                  <th class="py-3 px-4">Item</th>
                  <th class="py-3 px-4">Categoria</th>
                  <th class="py-3 px-4">Status</th>
                  <th class="py-3 px-4 text-right">Ações</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-zinc-100">
                <tr v-for="product in paginatedProducts" :key="product.id" class="hover:bg-zinc-50/50 transition-colors">
                  <td class="py-3 px-4">
                    <div class="flex items-center gap-3">
                      <div class="w-9 h-9 rounded bg-zinc-100 border border-zinc-200/80 overflow-hidden shrink-0 flex items-center justify-center">
                        <img v-if="product.image" :src="product.image" :alt="product.name" class="w-full h-full object-cover" />
                        <Package v-else :size="14" class="text-zinc-400" />
                      </div>
                      <div>
                        <span class="font-semibold text-zinc-800 block text-xs">{{ product.name }}</span>
                        <span class="text-[11px] text-zinc-400 line-clamp-1 max-w-sm">{{ product.description || 'Sem descrição' }}</span>
                      </div>
                    </div>
                  </td>
                  <td class="py-3 px-4">
                    <span class="text-[11px] font-medium text-zinc-700 bg-zinc-100 px-2 py-0.5 rounded border border-zinc-200/60">
                      {{ product.category ? product.category.name : 'Geral' }}
                    </span>
                  </td>
                  <td class="py-3 px-4">
                    <span 
                      :class="product.is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-zinc-100 text-zinc-600 border-zinc-200'"
                      class="text-[10px] font-medium px-2 py-0.5 rounded border"
                    >
                      {{ product.is_active ? 'Ativo' : 'Inativo' }}
                    </span>
                  </td>
                  <td class="py-3 px-4 text-right space-x-3">
                    <button @click="openEditModal(product)" class="font-medium text-zinc-700 hover:text-zinc-950 transition-colors cursor-pointer">
                      Editar
                    </button>
                    <button @click="deleteProduct(product.id)" class="font-medium text-rose-600 hover:text-rose-700 transition-colors cursor-pointer">
                      Excluir
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination (8 per page) -->
        <AdminPagination 
          :total="products.length" 
          :per-page="perPage" 
          v-model:current-page="currentPage" 
        />
      </div>
    </div>

    <ProductModal 
      v-if="isModalOpen" 
      :product="selectedProduct" 
      @close="isModalOpen = false" 
      @saved="loadProducts" 
    />
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { Plus, Package } from 'lucide-vue-next';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import ProductModal from '../../Components/Admin/Products/ProductModal.vue';
import AdminPagination from '../../Components/Admin/Common/AdminPagination.vue';

const products = ref([]);
const isLoading = ref(true);
const isModalOpen = ref(false);
const selectedProduct = ref(null);
const currentPage = ref(1);
const perPage = 8;

const paginatedProducts = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return products.value.slice(start, start + perPage);
});

const loadProducts = async () => {
  isLoading.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    const res = await axios.get('/api/admin/products', {
      headers: { Authorization: `Bearer ${token}` }
    });
    products.value = Array.isArray(res.data) ? res.data : (res.data.data || []);
  } catch (err) {
    console.error('Erro ao carregar produtos:', err);
  } finally {
    isLoading.value = false;
  }
};

const openCreateModal = () => { selectedProduct.value = null; isModalOpen.value = true; };
const openEditModal = (product) => { selectedProduct.value = { ...product }; isModalOpen.value = true; };

const deleteProduct = async (id) => {
  if (!confirm('Confirmar exclusão deste produto?')) return;
  const token = localStorage.getItem('admin_token');
  try {
    await axios.delete(`/api/admin/products/${id}`, { headers: { Authorization: `Bearer ${token}` } });
    loadProducts();
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao excluir produto.');
  }
};

onMounted(loadProducts);
</script>
