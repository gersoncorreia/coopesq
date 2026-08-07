<template>
  <AdminLayout>
    <div class="space-y-6">
      <div class="flex justify-between items-center bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
          <h2 class="text-xl font-extrabold text-slate-900">Parceiros e Clientes Atendidos</h2>
          <p class="text-xs text-slate-500">Gerencie as logomarcas exibidas na grade de parceiros do site.</p>
        </div>
        <button 
          @click="showModal = true" 
          class="bg-coopesq-green hover:bg-coopesq-green-dark text-white font-bold px-5 py-2.5 rounded-xl shadow-md transition-all text-sm flex items-center gap-2"
        >
          ➕ Novo Parceiro
        </button>
      </div>

      <!-- Grid de Parceiros -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div v-for="partner in partners" :key="partner.id" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-emerald-100 text-coopesq-green font-bold flex items-center justify-center text-base">
              🏛️
            </div>
            <div>
              <h4 class="font-bold text-slate-900 text-sm">{{ partner.name }}</h4>
              <a v-if="partner.url" :href="partner.url" target="_blank" class="text-xs text-coopesq-green hover:underline">Link Institucional</a>
            </div>
          </div>
          <button @click="deletePartner(partner.id)" class="text-xs text-red-600 font-bold hover:underline">Excluir</button>
        </div>
      </div>

      <!-- Modal Modal Criar Parceiro -->
      <div v-if="showModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-6 max-w-lg w-full shadow-2xl border border-slate-200">
          <h3 class="text-lg font-bold text-slate-900 mb-4">Cadastrar Novo Parceiro</h3>
          <form @submit.prevent="createPartner" class="space-y-4">
            <div>
              <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Nome da Instituição / Cliente</label>
              <input v-model="newPartner.name" type="text" required class="w-full p-2.5 rounded-lg border border-slate-300 text-sm" />
            </div>
            <div>
              <label class="block text-xs font-bold uppercase text-slate-700 mb-1">URL (Opcional)</label>
              <input v-model="newPartner.url" type="url" placeholder="https://..." class="w-full p-2.5 rounded-lg border border-slate-300 text-sm" />
            </div>
            <div class="flex justify-end gap-3 pt-4">
              <button type="button" @click="showModal = false" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-lg">Cancelar</button>
              <button type="submit" class="px-5 py-2 text-xs font-bold bg-coopesq-green text-white rounded-lg shadow-sm">Salvar Parceiro</button>
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

const partners = ref([]);
const showModal = ref(false);
const newPartner = ref({
  name: '',
  url: '',
});

const loadPartners = async () => {
  try {
    const res = await axios.get('/api/partners');
    partners.value = res.data || [];
  } catch (err) {
    console.error('Erro ao carregar parceiros:', err);
  }
};

const createPartner = async () => {
  const token = localStorage.getItem('admin_token');
  try {
    await axios.post('/api/admin/partners', {
      ...newPartner.value,
      logo: '/images/partners/default.png',
      is_active: true,
      order: 0,
    }, {
      headers: { Authorization: `Bearer ${token}` }
    });
    showModal.value = false;
    newPartner.value = { name: '', url: '' };
    loadPartners();
  } catch (err) {
    console.error('Erro ao criar parceiro:', err);
  }
};

const deletePartner = async (id) => {
  if (!confirm('Deseja excluir este parceiro?')) return;
  const token = localStorage.getItem('admin_token');
  try {
    await axios.delete(`/api/admin/partners/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    });
    loadPartners();
  } catch (err) {
    console.error('Erro ao excluir parceiro:', err);
  }
};

onMounted(() => {
  loadPartners();
});
</script>
