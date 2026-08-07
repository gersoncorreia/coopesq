<template>
  <section class="py-24 sm:py-28 bg-coopesq-green-pale">
    <div class="max-w-6xl mx-auto px-6 sm:px-8 lg:px-12">
      <div v-reveal class="text-center mb-16">
        <div class="flex items-center justify-center gap-3 mb-4">
          <div class="h-0.5 w-8 bg-coopesq-orange"></div>
          <span class="text-xs font-bold text-coopesq-orange uppercase tracking-widest">Depoimentos</span>
          <div class="h-0.5 w-8 bg-coopesq-orange"></div>
        </div>
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900">
          O que dizem nossos cooperados
        </h2>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div 
          v-for="(testimonial, i) in testimonials" 
          :key="testimonial.id"
          v-reveal
          :class="`delay-${(i + 1) * 200}`"
          class="reveal-scale relative bg-white rounded-3xl p-8 border border-emerald-100 card-lift"
        >
          <div class="font-display text-8xl text-coopesq-green/10 absolute top-4 right-6 leading-none select-none">"</div>
          <div class="relative">
            <p class="text-slate-700 leading-relaxed mb-6 text-base italic">
              "{{ testimonial.content }}"
            </p>
            <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
              <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-coopesq-green to-coopesq-green-mid flex items-center justify-center text-white font-bold text-lg">
                {{ (testimonial.name || '?').charAt(0).toUpperCase() }}
              </div>
              <div>
                <div class="font-bold text-slate-900 text-sm">{{ testimonial.name }}</div>
                <div class="text-xs text-coopesq-green font-medium">{{ testimonial.role }}</div>
              </div>
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
