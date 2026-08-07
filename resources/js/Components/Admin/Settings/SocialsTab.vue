<template>
  <div class="space-y-4 max-w-3xl">
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Handle Instagram</label>
      <input v-model="form.instagram" type="text" placeholder="@coopesq" class="w-full p-3 rounded-lg border border-slate-300 text-sm" />
    </div>
    <div>
      <label class="block text-xs font-bold uppercase text-slate-700 mb-1">URL Completa Instagram</label>
      <input v-model="form.instagram_url" type="url" placeholder="https://instagram.com/coopesq" class="w-full p-3 rounded-lg border border-slate-300 text-sm" />
    </div>
  </div>
</template>

<script setup>
defineProps({ form: { type: Object, required: true } });
</script>
