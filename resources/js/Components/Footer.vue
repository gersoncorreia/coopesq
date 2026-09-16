<template>
  <footer id="contato" class="bg-[#0a1a0c] text-white">
    <!-- Pre-footer contact strip -->
    <div class="border-b border-white/5 py-12">
      <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Phone 1 -->
          <div class="flex items-center gap-4 group">
            <div class="w-12 h-12 rounded-2xl bg-coopesq-green/20 border border-coopesq-green/30 flex items-center justify-center text-coopesq-orange text-xl flex-shrink-0 group-hover:bg-coopesq-green/30 transition-colors">📞</div>
            <div>
              <div class="text-xs font-bold text-white/40 uppercase tracking-wider mb-0.5">Telefone Comercial</div>
              <div class="font-bold text-white">{{ settingsStore.contacts.phone_primary || '(61) 99576-3665' }}</div>
            </div>
          </div>
          <!-- Email -->
          <div class="flex items-center gap-4 group">
            <div class="w-12 h-12 rounded-2xl bg-coopesq-orange/15 border border-coopesq-orange/25 flex items-center justify-center text-coopesq-orange text-xl flex-shrink-0 group-hover:bg-coopesq-orange/25 transition-colors">✉️</div>
            <div>
              <div class="text-xs font-bold text-white/40 uppercase tracking-wider mb-0.5">E-mail Corporativo</div>
              <a :href="`mailto:${settingsStore.contacts.email}`" class="font-bold text-white hover:text-coopesq-orange transition-colors">
                {{ settingsStore.contacts.email || 'coopesqcooperativa@gmail.com' }}
              </a>
            </div>
          </div>
          <!-- Address -->
          <div class="flex items-center gap-4 group">
            <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-xl flex-shrink-0 group-hover:bg-white/10 transition-colors">📍</div>
            <div>
              <div class="text-xs font-bold text-white/40 uppercase tracking-wider mb-0.5">Localização</div>
              <div class="font-bold text-white">{{ settingsStore.contacts.address || 'Porto Acre - AC, Brasil' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main footer -->
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-16">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-10">
        <!-- Brand -->
        <div class="flex flex-col items-start">
          <div class="mb-5">
            <template v-if="settingsStore.general.site_logo_footer || settingsStore.general.site_logo">
              <img 
                :src="settingsStore.general.site_logo_footer || settingsStore.general.site_logo" 
                :alt="settingsStore.general.site_name || 'COOPESQ'" 
                class="w-auto h-28 sm:h-32 max-w-full object-contain rounded-2xl drop-shadow-md transition-transform duration-200 hover:scale-[1.02]"
              />
            </template>
            <template v-else>
              <div class="flex items-center gap-3">
                <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-[#1B5E20] via-[#236e29] to-[#123e15] border border-emerald-500/30 flex items-center justify-center font-black text-white text-xl shadow-lg">
                  <span class="text-[#F5A623]">C</span>
                  <div class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-[#F5A623] rounded-full ring-2 ring-[#0a1a0c]"></div>
                </div>
                <div>
                  <span class="font-black text-2xl text-white block tracking-wider">{{ settingsStore.general.site_name || 'COOPESQ' }}</span>
                </div>
              </div>
            </template>
          </div>
          <p class="text-white/50 text-xs leading-relaxed">
            {{ settingsStore.general.site_tagline || 'Promovendo o desenvolvimento sustentável e a piscicultura de excelência na Amazônia.' }}
          </p>
        </div>

        <!-- Links Rápidos -->
        <div>
          <h4 class="text-xs font-bold text-coopesq-orange uppercase tracking-widest mb-5">Navegação</h4>
          <ul class="space-y-3">
            <li><a href="/" @click.prevent="navigateToHome" class="nav-link-animated text-white/50 hover:text-white text-sm font-medium transition-colors cursor-pointer">Início</a></li>
            <li><a href="#sobre" @click.prevent="navigateToSection('sobre')" class="nav-link-animated text-white/50 hover:text-white text-sm font-medium transition-colors cursor-pointer">Sobre a Cooperativa</a></li>
            <li><a href="#diferenciais" @click.prevent="navigateToSection('diferenciais')" class="nav-link-animated text-white/50 hover:text-white text-sm font-medium transition-colors cursor-pointer">Nossos Diferenciais</a></li>
            <li><a href="#produtos" @click.prevent="navigateToSection('produtos')" class="nav-link-animated text-white/50 hover:text-white text-sm font-medium transition-colors cursor-pointer">Catálogo de Produtos</a></li>
            <li><router-link to="/blog" class="nav-link-animated text-white/50 hover:text-white text-sm font-medium transition-colors cursor-pointer">Notícias e Blog</router-link></li>
          </ul>
        </div>

        <!-- Produtos -->
        <div>
          <h4 class="text-xs font-bold text-coopesq-orange uppercase tracking-widest mb-5">Produtos</h4>
          <ul class="space-y-3 text-sm text-white/50">
            <li class="font-medium">🐟 Piscicultura Amazônica</li>
            <li class="font-medium">🍉 Frutas Regionais</li>
            <li class="font-medium">🥔 Raízes e Tubérculos</li>
            <li class="font-medium">🥬 Verduras e Hortaliças</li>
          </ul>
        </div>

        <!-- Contato -->
        <div>
          <h4 class="text-xs font-bold text-coopesq-orange uppercase tracking-widest mb-5">Outros Telefones</h4>
          <ul class="space-y-3 text-sm text-white/50">
            <li class="font-medium">{{ settingsStore.contacts.phone_secondary || '(69) 99954-7575' }}</li>
            <li class="font-medium">{{ settingsStore.contacts.phone_tertiary || '(68) 99927-4776' }}</li>
          </ul>
          <div class="mt-6">
            <a href="https://wa.me/5568999274776" target="_blank" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-bold text-xs px-4 py-3 rounded-xl transition-colors">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              Solicitar Cotação
            </a>
          </div>
        </div>

        <!-- Redes Sociais -->
        <div>
          <h4 class="text-xs font-bold text-coopesq-orange uppercase tracking-widest mb-5">Redes Sociais</h4>
          <p class="text-white/50 text-xs leading-relaxed mb-4">Acompanhe nossas novidades, manejos e projetos na Amazônia:</p>
          <a :href="settingsStore.socials.instagram_url || 'https://instagram.com/coopesq'" target="_blank" class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white/80 hover:text-white font-semibold text-xs px-4 py-2.5 rounded-xl transition-all">
            <svg class="w-4 h-4 text-[#F5A623]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            <span>{{ settingsStore.socials.instagram || '@coopesq' }}</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Copyright bar -->
    <div class="border-t border-white/5 py-6">
      <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/25 font-medium">
        <span>© 2026 {{ settingsStore.general.site_name || 'COOPESQ' }}. Todos os direitos reservados.</span>
        <span>Cooperativismo & Sustentabilidade na Amazônia</span>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router';
import { useSettingsStore } from '../stores/useSettingsStore';

const settingsStore = useSettingsStore();
const route = useRoute();
const router = useRouter();

const navigateToSection = async (id) => {
  if (route.path !== '/') await router.push({ path: '/', hash: `#${id}` });
  setTimeout(() => document.getElementById(id)?.scrollIntoView({ behavior: 'smooth', block: 'start' }), route.path !== '/' ? 250 : 0);
};

const navigateToHome = () => {
  if (route.path === '/') window.scrollTo({ top: 0, behavior: 'smooth' });
  else router.push('/');
};
</script>
