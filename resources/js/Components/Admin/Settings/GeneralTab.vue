<template>
  <div class="space-y-4 max-w-3xl">
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Nome da Cooperativa / Site</label>
      <input v-model="form.site_name" type="text" class="w-full p-3 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-coopesq-green focus:outline-none" />
    </div>
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Slogan / Tagline</label>
      <input v-model="form.site_tagline" type="text" class="w-full p-3 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-coopesq-green focus:outline-none" />
    </div>
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Missão</label>
      <textarea v-model="form.mission" rows="3" class="w-full p-3 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-coopesq-green focus:outline-none"></textarea>
    </div>
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Visão</label>
      <textarea v-model="form.vision" rows="3" class="w-full p-3 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-coopesq-green focus:outline-none"></textarea>
    </div>
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Valores</label>
      <textarea v-model="form.values" rows="3" class="w-full p-3 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-coopesq-green focus:outline-none"></textarea>
    </div>
  </div>
</template>

<script setup>
defineProps({
  form: { type: Object, required: true },
});
</script>
