<template>
  <div class="divide-y divide-zinc-200/80">
    <!-- Seção 1: Canais de Atendimento -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-6 first:pt-0">
      <div class="space-y-1">
        <h3 class="text-sm font-bold text-zinc-900 flex items-center gap-2">
          <Phone :size="16" class="text-[#1B5E20]" />
          <span>Atendimento Telefônico</span>
        </h3>
        <p class="text-xs text-zinc-500 leading-relaxed">
          Números para atendimento a cooperados, clientes e fornecedores por região.
        </p>
      </div>

      <div class="md:col-span-2 space-y-4 max-w-2xl">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <div>
            <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Brasília / DF (Central)</label>
            <input 
              v-model="form.phone_primary" 
              type="text" 
              class="w-full h-9 px-3 rounded-md border border-zinc-200 bg-white text-xs font-mono font-medium text-zinc-900 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
            />
          </div>
          <div>
            <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Rondônia (Operacional)</label>
            <input 
              v-model="form.phone_secondary" 
              type="text" 
              class="w-full h-9 px-3 rounded-md border border-zinc-200 bg-white text-xs font-mono font-medium text-zinc-900 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
            />
          </div>
          <div>
            <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Acre (Sede Local)</label>
            <input 
              v-model="form.phone_tertiary" 
              type="text" 
              class="w-full h-9 px-3 rounded-md border border-zinc-200 bg-white text-xs font-mono font-medium text-zinc-900 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
            />
          </div>
        </div>
      </div>
    </div>

    <!-- Seção 2: Localização & Correio -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-6">
      <div class="space-y-1">
        <h3 class="text-sm font-bold text-zinc-900 flex items-center gap-2">
          <MapPin :size="16" class="text-[#1B5E20]" />
          <span>Localização & E-mail</span>
        </h3>
        <p class="text-xs text-zinc-500 leading-relaxed">
          Endereço físico oficial e e-mail de contato para correspondências formais.
        </p>
      </div>

      <div class="md:col-span-2 space-y-4 max-w-2xl">
        <div>
          <label class="block text-xs font-semibold text-zinc-700 mb-1.5">E-mail Institucional</label>
          <div class="relative">
            <input 
              v-model="form.email" 
              type="email" 
              class="w-full h-9 pl-9 pr-3 rounded-md border border-zinc-200 bg-white text-xs font-medium text-zinc-900 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
            />
            <Mail :size="14" class="text-zinc-400 absolute left-3 top-2.5" />
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Endereço Completo da Sede</label>
          <input 
            v-model="form.address" 
            type="text" 
            class="w-full h-9 px-3 rounded-md border border-zinc-200 bg-white text-xs font-medium text-zinc-900 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Phone, MapPin, Mail } from 'lucide-vue-next';

defineProps({ form: { type: Object, required: true } });
</script>
