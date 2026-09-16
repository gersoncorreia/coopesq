<template>
  <AdminLayout>
    <div class="space-y-5">
      <!-- Section Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-200/80">
        <div>
          <h1 class="text-xl font-bold tracking-tight text-zinc-900">Usuários & Operadores</h1>
          <p class="text-xs text-zinc-500 mt-0.5">Gerencie os operadores com permissões de acesso ao painel.</p>
        </div>
        <button 
          @click="openCreateModal"
          class="h-8 px-3 rounded-md text-xs font-medium bg-[#1B5E20] hover:bg-[#144718] text-white shadow-xs transition-colors inline-flex items-center gap-1.5 self-start cursor-pointer"
        >
          <Plus :size="14" />
          <span>Novo Usuário</span>
        </button>
      </div>

      <div v-if="isLoading" class="p-12 text-center text-xs text-zinc-400 font-medium">
        Carregando operadores...
      </div>

      <!-- Users Table with Responsive Horizontal Scroll & Pagination -->
      <div v-else class="space-y-3">
        <div class="bg-white rounded-lg border border-zinc-200/80 shadow-xs overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left text-xs min-w-[500px]">
              <thead class="bg-zinc-50/80 border-b border-zinc-200/70 text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
                <tr>
                  <th class="py-3 px-4">Operador</th>
                  <th class="py-3 px-4">E-mail</th>
                  <th class="py-3 px-4">Função</th>
                  <th class="py-3 px-4">Criado em</th>
                  <th class="py-3 px-4 text-right">Ações</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-zinc-100">
                <tr v-for="user in paginatedUsers" :key="user.id" class="hover:bg-zinc-50/50 transition-colors">
                  <td class="py-3 px-4">
                    <div class="flex items-center gap-2.5">
                      <div class="w-7 h-7 rounded bg-zinc-100 text-zinc-700 font-bold flex items-center justify-center text-xs border border-zinc-200">
                        {{ user.name.charAt(0) }}
                      </div>
                      <span class="font-semibold text-zinc-900">{{ user.name }}</span>
                    </div>
                  </td>
                  <td class="py-3 px-4 text-zinc-600 font-mono text-[11px]">{{ user.email }}</td>
                  <td class="py-3 px-4">
                    <span 
                      :class="user.role === 'admin' ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-blue-50 text-blue-800 border-blue-200'"
                      class="text-[10px] font-bold px-2 py-0.5 rounded border uppercase"
                    >
                      {{ user.role === 'admin' ? 'Administrador' : 'Editor' }}
                    </span>
                  </td>
                  <td class="py-3 px-4 text-zinc-500 font-mono text-[11px]">
                    {{ user.created_at ? new Date(user.created_at).toLocaleDateString('pt-BR') : '-' }}
                  </td>
                  <td class="py-3 px-4 text-right space-x-3">
                    <button @click="openEditModal(user)" class="font-medium text-zinc-700 hover:text-zinc-950 transition-colors cursor-pointer">
                      Editar
                    </button>
                    <button @click="deleteUser(user.id)" class="font-medium text-rose-600 hover:text-rose-700 transition-colors cursor-pointer">
                      Excluir
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <AdminPagination 
          :total="users.length" 
          :per-page="perPage" 
          v-model:current-page="currentPage" 
        />
      </div>
    </div>

    <UserModal 
      v-if="isModalOpen" 
      :user="selectedUser" 
      @close="isModalOpen = false" 
      @saved="fetchUsers" 
    />
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { Plus } from 'lucide-vue-next';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import UserModal from '../../Components/Admin/Users/UserModal.vue';
import AdminPagination from '../../Components/Admin/Common/AdminPagination.vue';

const users = ref([]);
const isLoading = ref(true);
const isModalOpen = ref(false);
const selectedUser = ref(null);
const currentPage = ref(1);
const perPage = 8;

const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return users.value.slice(start, start + perPage);
});

const fetchUsers = async () => {
  isLoading.value = true;
  const token = localStorage.getItem('admin_token');
  try {
    const res = await axios.get('/api/admin/users', {
      headers: { Authorization: `Bearer ${token}` }
    });
    users.value = Array.isArray(res.data) ? res.data : (res.data.data || []);
  } catch (err) {
    console.error('Erro ao carregar usuários:', err);
  } finally {
    isLoading.value = false;
  }
};

const openCreateModal = () => { selectedUser.value = null; isModalOpen.value = true; };
const openEditModal = (user) => { selectedUser.value = { ...user }; isModalOpen.value = true; };

const deleteUser = async (id) => {
  if (!confirm('Confirmar exclusão deste operador?')) return;
  const token = localStorage.getItem('admin_token');
  try {
    await axios.delete(`/api/admin/users/${id}`, { headers: { Authorization: `Bearer ${token}` } });
    fetchUsers();
  } catch (err) {
    alert(err.response?.data?.message || 'Erro ao excluir usuário.');
  }
};

onMounted(fetchUsers);
</script>
