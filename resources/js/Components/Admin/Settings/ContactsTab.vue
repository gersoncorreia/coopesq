<template>
  <div class="space-y-4 max-w-3xl">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Telefone 1</label>
        <input v-model="form.phone_primary" type="text" class="w-full p-3 rounded-lg border border-slate-300 text-sm" />
      </div>
      <div>
        <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Telefone 2</label>
        <input v-model="form.phone_secondary" type="text" class="w-full p-3 rounded-lg border border-slate-300 text-sm" />
      </div>
      <div>
        <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Telefone 3</label>
        <input v-model="form.phone_tertiary" type="text" class="w-full p-3 rounded-lg border border-slate-300 text-sm" />
      </div>
    </div>
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">E-mail de Contato</label>
      <input v-model="form.email" type="email" class="w-full p-3 rounded-lg border border-slate-300 text-sm" />
    </div>
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Endereço Físico</label>
      <input v-model="form.address" type="text" class="w-full p-3 rounded-lg border border-slate-300 text-sm" />
    </div>
  </div>
</template>

<script setup>
defineProps({ form: { type: Object, required: true } });
</script>
