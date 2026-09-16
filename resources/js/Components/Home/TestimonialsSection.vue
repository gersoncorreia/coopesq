<template>
  <section class="py-24 sm:py-32 bg-slate-50">
    <div class="max-w-6xl mx-auto px-6 sm:px-8 lg:px-12">
      <!-- Header no padrão Khela -->
      <div v-reveal class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
        <span class="text-xs font-bold text-[#F5A623] uppercase tracking-[0.25em] block mb-2">
          Testimonials • Depoimentos
        </span>
        <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-slate-900 uppercase tracking-tight">
          O QUE DIZEM <span class="text-[#1B5E20]">NOSSOS PARCEIROS</span>
        </h2>
        <div class="w-12 h-1 bg-[#1B5E20] mx-auto mt-4 rounded-full"></div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div 
          v-for="(testimonial, i) in testimonials" 
          :key="testimonial.id" 
          v-reveal
          :class="`delay-${(i + 1) * 200}`"
          class="reveal-scale relative bg-white rounded-xl p-8 border border-slate-200/80 shadow-xs hover:shadow-xl transition-all duration-300 card-lift flex flex-col justify-between"
        >
          <div class="relative">
            <div class="text-[#F5A623] text-2xl mb-4 font-serif leading-none select-none">“</div>
            <p class="text-slate-600 leading-relaxed mb-6 text-sm italic font-normal">
              {{ testimonial.content }}
            </p>
          </div>
          <div class="flex items-center gap-4 pt-5 border-t border-slate-100">
            <div class="w-11 h-11 rounded-lg bg-[#1B5E20] flex items-center justify-center text-white font-bold text-base overflow-hidden shrink-0 shadow-sm">
              <img 
                v-if="testimonial.image" 
                :src="testimonial.image" 
                :alt="testimonial.name" 
                class="w-full h-full object-cover"
                @error="(e) => e.target.style.display = 'none'"
              />
              <span v-if="!testimonial.image">{{ (testimonial.name || '?').charAt(0).toUpperCase() }}</span>
            </div>
            <div>
              <div class="font-bold text-slate-900 text-sm leading-tight">{{ testimonial.name }}</div>
              <div class="text-xs text-[#1B5E20] font-medium leading-tight mt-0.5">{{ testimonial.role }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  testimonials: { type: Array, default: () => [] },
});
</script>
