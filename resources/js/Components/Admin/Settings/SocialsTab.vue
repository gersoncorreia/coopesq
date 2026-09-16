<template>
  <div class="divide-y divide-zinc-200/80">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-6 first:pt-0">
      <div class="space-y-1">
        <h3 class="text-sm font-bold text-zinc-900 flex items-center gap-2">
          <Share2 :size="16" class="text-[#1B5E20]" />
          <span>Instagram & Redes</span>
        </h3>
        <p class="text-xs text-zinc-500 leading-relaxed">
          Presença oficial nas redes sociais para conexão com cooperados e clientes.
        </p>
      </div>

      <div class="md:col-span-2 space-y-4 max-w-2xl">
        <div>
          <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Perfil Oficial do Instagram</label>
          <div class="flex items-center">
            <span class="h-9 px-3 bg-zinc-100 border border-r-0 border-zinc-200 rounded-l-md text-xs font-semibold text-zinc-500 flex items-center">
              @
            </span>
            <input 
              v-model="form.instagram" 
              type="text" 
              placeholder="coopesq" 
              class="w-full h-9 px-3 rounded-r-md border border-zinc-200 bg-white text-xs font-medium text-zinc-900 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
            />
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-zinc-700 mb-1.5">URL Direta do Perfil</label>
          <input 
            v-model="form.instagram_url" 
            type="url" 
            placeholder="https://instagram.com/coopesq" 
            class="w-full h-9 px-3 rounded-md border border-zinc-200 bg-white text-xs text-zinc-800 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Share2 } from 'lucide-vue-next';

defineProps({ form: { type: Object, required: true } });
</script>
