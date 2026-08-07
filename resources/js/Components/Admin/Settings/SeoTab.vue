<template>
  <div class="space-y-4 max-w-3xl">
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Meta Title Global</label>
      <input v-model="form.meta_title" type="text" class="w-full p-3 rounded-lg border border-slate-300 text-sm" />
    </div>
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Meta Description Global</label>
      <textarea v-model="form.meta_description" rows="3" class="w-full p-3 rounded-lg border border-slate-300 text-sm"></textarea>
    </div>
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Palavras-chave (SEO Keywords)</label>
      <input v-model="form.meta_keywords" type="text" placeholder="piscicultura, amazonia, tambaqui..." class="w-full p-3 rounded-lg border border-slate-300 text-sm" />
    </div>
  </div>
</template>

<script setup>
defineProps({ form: { type: Object, required: true } });
</script>
