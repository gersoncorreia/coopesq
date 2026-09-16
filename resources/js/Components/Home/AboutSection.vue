<template>
  <section id="sobre" class="py-24 sm:py-32 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
      <!-- Section Header no padrão Khela -->
      <div v-reveal class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
        <span class="text-xs font-bold text-[#F5A623] uppercase tracking-[0.25em] block mb-2">
          A Short Brief • Sobre Nós
        </span>
        <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 uppercase tracking-tight">
          QUEM É A <span class="text-[#1B5E20]">COOPESQ</span>
        </h2>
        <div class="w-12 h-1 bg-[#1B5E20] mx-auto mt-4 rounded-full"></div>
      </div>

      <!-- Split Layout Khela: Imagem com Badge Flutuante + Conteúdo -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
        <!-- Coluna Esquerda: Imagem Institucional + Badge -->
        <div v-reveal class="reveal-left lg:col-span-5 relative">
          <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-slate-100 bg-slate-100">
            <img 
              :src="settings.about_image || 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=900&q=80'" 
              alt="Produção Sustentável COOPESQ" 
              class="w-full h-[460px] object-cover hover:scale-105 transition-transform duration-700"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
            
            <!-- Floating Badge Khela Style -->
            <div class="absolute bottom-6 left-6 right-6 bg-white/95 backdrop-blur-md p-4 rounded-xl shadow-lg border border-slate-200/80 flex items-center gap-4">
              <div class="w-12 h-12 rounded-lg bg-[#1B5E20] text-white font-bold flex items-center justify-center text-xl shrink-0 shadow-md">
                100%
              </div>
              <div>
                <span class="text-xs font-bold text-slate-900 block leading-tight">Origem Amazônica</span>
                <span class="text-[11px] text-slate-500 block leading-tight">Pescados e agricultura familiar</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Coluna Direita: Descrição e Pilares Corporativos -->
        <div v-reveal class="reveal-right lg:col-span-7 space-y-6">
          <h3 class="text-xl sm:text-2xl font-bold text-slate-900 leading-snug">
            Unindo cooperados locais para alimentar o Brasil com <span class="text-[#1B5E20]">responsabilidade ambiental</span>.
          </h3>
          <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
            A Cooperativa COOPESQ atua na vanguarda da piscicultura sustentável e do agronegócio familiar na Amazônia Ocidental. Focamos no manejo responsável, na preservação dos igarapés e no desenvolvimento econômico das famílias produtoras.
          </p>

          <!-- Grid de Pilares (Missão, Visão, Valores) no padrão Khela -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-100">
            <!-- Missão -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 hover:border-[#1B5E20]/40 transition-colors">
              <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#1B5E20] flex items-center justify-center mb-3">
                <Target :size="16" />
              </div>
              <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-1">Missão</h4>
              <p class="text-slate-500 text-xs leading-relaxed line-clamp-3">
                {{ settings.mission || 'Fomentar a piscicultura e o agronegócio sustentável.' }}
              </p>
            </div>

            <!-- Visão -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 hover:border-[#F5A623]/40 transition-colors">
              <div class="w-8 h-8 rounded-lg bg-amber-100 text-[#d48b16] flex items-center justify-center mb-3">
                <Eye :size="16" />
              </div>
              <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-1">Visão</h4>
              <p class="text-slate-500 text-xs leading-relaxed line-clamp-3">
                {{ settings.vision || 'Ser referência nacional em produção ética na Amazônia.' }}
              </p>
            </div>

            <!-- Valores -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 hover:border-emerald-300 transition-colors">
              <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#1B5E20] flex items-center justify-center mb-3">
                <ShieldCheck :size="16" />
              </div>
              <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-1">Valores</h4>
              <p class="text-slate-500 text-xs leading-relaxed line-clamp-3">
                {{ settings.values || 'Transparência, solidariedade e respeito à terra.' }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Target, Eye, ShieldCheck } from 'lucide-vue-next';

defineProps({
  settings: { type: Object, default: () => ({}) },
});
</script>
