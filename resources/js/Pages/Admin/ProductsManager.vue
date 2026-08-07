<template>
  <AdminLayout>
    <div class="space-y-6">
      <div class="flex justify-between items-center bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
          <h2 class="text-xl font-extrabold text-slate-900">Catálogo de Produtos</h2>
          <p class="text-xs text-slate-500">Gerencie os pescados, frutas, raízes e verduras exibidos no site.</p>
        </div>
        <button 
          @click="showModal = true" 
          class="bg-coopesq-green hover:bg-coopesq-green-dark text-white font-bold px-5 py-2.5 rounded-xl shadow-md transition-all text-sm flex items-center gap-2"
        >
          ➕ Novo Produto
        </button>
      </div>

      <!-- Tabela de Produtos -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm border-collapse">
          <thead class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-500">
            <tr>
              <th class="p-4">Produto</th>
              <th class="p-4">Categoria</th>
              <th class="p-4">Status</th>
              <th class="p-4 text-right">Ações</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="product in products" :key="product.id" class="hover:bg-slate-50/80 transition-colors">
              <td class="p-4 font-semibold text-slate-900">{{ product.name }}</td>
              <td class="p-4">
                <span class="bg-emerald-50 text-coopesq-green font-bold text-xs px-2.5 py-1 rounded-full">
                  {{ product.category ? product.category.name : 'Geral' }}
                </span>
              </td>
              <td class="p-4">
                <span :class="[product.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800']" class="text-xs font-bold px-2.5 py-1 rounded-full">
                  {{ product.is_active ? 'Ativo' : 'Inativo' }}
                </span>
              </td>
              <td class="p-4 text-right space-x-2">
                <button @click="deleteProduct(product.id)" class="text-xs text-red-600 hover:underline font-semibold">Excluir</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal Modal Criar Produto -->
      <div v-if="showModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-6 max-w-lg w-full shadow-2xl border border-slate-200">
          <h3 class="text-lg font-bold text-slate-900 mb-4">Cadastrar Novo Produto</h3>
          <form @submit.prevent="createProduct" class="space-y-4">
            <div>
              <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Nome do Produto</label>
              <input v-model="newProduct.name" type="text" required class="w-full p-2.5 rounded-lg border border-slate-300 text-sm" />
            </div>
            <div>
              <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Categoria</label>
              <select v-model="newProduct.category_id" required class="w-full p-2.5 rounded-lg border border-slate-300 text-sm">
                <option value="1">Piscicultura</option>
                <option value="2">Frutas Regionais</option>
                <option value="3">Raízes</option>
                <option value="4">Verduras e Hortaliças</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Descrição</label>
              <textarea v-model="newProduct.description" rows="3" class="w-full p-2.5 rounded-lg border border-slate-300 text-sm"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-4">
              <button type="button" @click="showModal = false" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-lg">Cancelar</button>
              <button type="submit" class="px-5 py-2 text-xs font-bold bg-coopesq-green text-white rounded-lg shadow-sm">Salvar Produto</button>
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

const products = ref([]);
const showModal = ref(false);
const newProduct = ref({
  name: '',
  category_id: '1',
  description: '',
});

const loadProducts = async () => {
  try {
    const res = await axios.get('/api/products?page=1');
    products.value = res.data.data || [];
  } catch (err) {
    console.error('Erro ao carregar produtos:', err);
  }
};

const createProduct = async () => {
  const token = localStorage.getItem('admin_token');
  const slug = newProduct.value.name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
  
  try {
    await axios.post('/api/admin/products', {
      ...newProduct.value,
      slug: slug,
      is_active: true,
      order: 0,
    }, {
      headers: { Authorization: `Bearer ${token}` }
    });
    showModal.value = false;
    newProduct.value = { name: '', category_id: '1', description: '' };
    loadProducts();
  } catch (err) {
    console.error('Erro ao criar produto:', err);
  }
};

const deleteProduct = async (id) => {
  if (!confirm('Deseja excluir este produto?')) return;
  const token = localStorage.getItem('admin_token');
  try {
    await axios.delete(`/api/admin/products/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    });
    loadProducts();
  } catch (err) {
    console.error('Erro ao excluir produto:', err);
  }
};

onMounted(() => {
  loadProducts();
});
</script>
