<template>
  <div class="divide-y divide-zinc-200/80">
    <!-- Seção 1: Identidade da Marca -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-6 first:pt-0">
      <div class="space-y-1">
        <h3 class="text-sm font-bold text-zinc-900 flex items-center gap-2">
          <Building :size="16" class="text-[#1B5E20]" />
          <span>Identidade & Marca</span>
        </h3>
        <p class="text-xs text-zinc-500 leading-relaxed">
          Nome fantasia e slogan público exibidos no cabeçalho e rodapé do portal.
        </p>
      </div>

      <div class="md:col-span-2 space-y-4 max-w-2xl">
        <div>
          <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Sigla / Nome da Cooperativa</label>
          <input 
            v-model="form.site_name" 
            type="text" 
            placeholder="Ex: COOPESQ"
            class="w-full h-9 px-3 rounded-md border border-zinc-200 bg-white text-xs font-medium text-zinc-900 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
          />
          <p class="text-[11px] text-zinc-400 mt-1">Nome conciso exibido ao lado do ícone quando não houver logomarca (ex: COOPESQ).</p>
        </div>

        <div>
          <label class="block text-xs font-semibold text-zinc-700 mb-1.5">Slogan / Tagline Institucional</label>
          <input 
            v-model="form.site_tagline" 
            type="text" 
            class="w-full h-9 px-3 rounded-md border border-zinc-200 bg-white text-xs text-zinc-800 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none shadow-2xs" 
          />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
          <ImageUploader 
            v-model="form.site_logo_header" 
            label="Logomarca Menu (Horizontal)" 
          />
          <ImageUploader 
            v-model="form.site_logo_footer" 
            label="Logomarca Rodapé (Quadrada)" 
          />
          <ImageUploader 
            v-model="form.site_favicon" 
            label="Ícone Navegador (Favicon)" 
          />
        </div>
      </div>
    </div>

    <!-- Seção 2: Pilares Estratégicos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-6">
      <div class="space-y-1">
        <h3 class="text-sm font-bold text-zinc-900 flex items-center gap-2">
          <Target :size="16" class="text-[#1B5E20]" />
          <span>Pilares Estratégicos</span>
        </h3>
        <p class="text-xs text-zinc-500 leading-relaxed">
          Declarações institucionais de propósito, metas de longo prazo e princípios cooperativos.
        </p>
      </div>

      <div class="md:col-span-2 space-y-4 max-w-2xl">
        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label class="text-xs font-semibold text-zinc-800 flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
              <span>Missão Corporativa</span>
            </label>
            <span class="text-[11px] text-zinc-400">Propósito e impacto</span>
          </div>
          <textarea 
            v-model="form.mission" 
            rows="3" 
            class="w-full p-3 rounded-md border border-zinc-200 bg-white text-xs text-zinc-800 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none leading-relaxed shadow-2xs resize-y"
          ></textarea>
        </div>

        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label class="text-xs font-semibold text-zinc-800 flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
              <span>Visão de Futuro</span>
            </label>
            <span class="text-[11px] text-zinc-400">Metas e projeção</span>
          </div>
          <textarea 
            v-model="form.vision" 
            rows="3" 
            class="w-full p-3 rounded-md border border-zinc-200 bg-white text-xs text-zinc-800 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none leading-relaxed shadow-2xs resize-y"
          ></textarea>
        </div>

        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label class="text-xs font-semibold text-zinc-800 flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
              <span>Valores Fundamentais</span>
            </label>
            <span class="text-[11px] text-zinc-400">Princípios éticos</span>
          </div>
          <textarea 
            v-model="form.values" 
            rows="3" 
            class="w-full p-3 rounded-md border border-zinc-200 bg-white text-xs text-zinc-800 focus:ring-1 focus:ring-[#1B5E20] focus:border-[#1B5E20] focus:outline-none leading-relaxed shadow-2xs resize-y"
          ></textarea>
        </div>
      </div>
    </div>

    <!-- Seção 3: Imagem Institucional da Seção Sobre Nós -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-6">
      <div class="space-y-1">
        <h3 class="text-sm font-bold text-zinc-900 flex items-center gap-2">
          <ImageIcon :size="16" class="text-[#1B5E20]" />
          <span>Imagem Institucional (Sobre Nós)</span>
        </h3>
        <p class="text-xs text-zinc-500 leading-relaxed">
          Foto de destaque exibida no card institucional da página inicial (substitui a imagem padrão).
        </p>
      </div>

      <div class="md:col-span-2 space-y-4 max-w-2xl">
        <ImageUploader 
          v-model="form.about_image" 
          label="Foto Institucional da Seção Sobre" 
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { Building, Target, Image as ImageIcon } from 'lucide-vue-next';
import ImageUploader from '../Common/ImageUploader.vue';

defineProps({
  form: { type: Object, required: true },
});
</script>
