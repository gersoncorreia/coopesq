<template>
  <div class="bg-white selection:bg-[#1B5E20] selection:text-white">
    <HeroSection :banners="banners" :is-loading="!isLoaded" @scroll-to="scrollTo" />
    <HeroFeatureBoxes />
    <AboutSection :settings="settingsStore.general" />
    <StatsCounterSection />
    <DifferentialsSection :differentials="differentials" />
    <ProductsSection 
      :products="products" 
      :categories="categories" 
      :active-category="activeCategory" 
      @select-category="handleCategorySelect" 
    />
    <PartnersSection :partners="partners" />
    <TestimonialsSection :testimonials="testimonials" />
    <BlogSection :posts="posts" />
    <CtaBannerSection />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import { useSettingsStore } from '../stores/useSettingsStore';
import HeroSection from '../Components/Home/HeroSection.vue';
import HeroFeatureBoxes from '../Components/Home/HeroFeatureBoxes.vue';
import AboutSection from '../Components/Home/AboutSection.vue';
import StatsCounterSection from '../Components/Home/StatsCounterSection.vue';
import DifferentialsSection from '../Components/Home/DifferentialsSection.vue';
import ProductsSection from '../Components/Home/ProductsSection.vue';
import PartnersSection from '../Components/Home/PartnersSection.vue';
import TestimonialsSection from '../Components/Home/TestimonialsSection.vue';
import BlogSection from '../Components/Home/BlogSection.vue';
import CtaBannerSection from '../Components/Home/CtaBannerSection.vue';

const settingsStore = useSettingsStore();

const getCachedBanners = () => {
  try {
    const cached = localStorage.getItem('coopesq_banners_cache');
    const parsed = cached ? JSON.parse(cached) : [];
    return Array.isArray(parsed) ? parsed : [];
  } catch {
    return [];
  }
};

const differentials = ref([]);
const products = ref([]);
const partners = ref([]);
const posts = ref([]);
const testimonials = ref([]);
const banners = ref(getCachedBanners());
const isLoaded = ref(banners.value.length > 0);
const activeCategory = ref('all');

const categories = [
  { slug: 'all', label: 'Todos' },
  { slug: 'piscicultura', label: '🐟 Piscicultura' },
  { slug: 'frutas-regionais', label: '🍉 Frutas' },
  { slug: 'raizes', label: '🥔 Raízes' },
  { slug: 'verduras-e-hortalicas', label: '🥬 Verduras' },
];

const scrollTo = (id) => {
  const el = document.getElementById(id);
  if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
};

const handleCategorySelect = (slug) => {
  activeCategory.value = slug;
};

const fetchHomeData = async () => {
  try {
    const [diffRes, prodRes, partRes, postRes, banRes, testRes] = await Promise.all([
      axios.get('/api/differentials'),
      axios.get('/api/products?page=1'),
      axios.get('/api/partners'),
      axios.get('/api/posts'),
      axios.get('/api/banners'),
      axios.get('/api/testimonials'),
    ]);
    differentials.value = Array.isArray(diffRes.data) ? diffRes.data : [];
    products.value = Array.isArray(prodRes.data?.data) ? prodRes.data.data : [];
    partners.value = Array.isArray(partRes.data) ? partRes.data : [];
    posts.value = Array.isArray(postRes.data?.data) ? postRes.data.data.slice(0, 3) : [];
    testimonials.value = Array.isArray(testRes.data) ? testRes.data : [];
    banners.value = Array.isArray(banRes.data) ? banRes.data : [];
    try {
      if (Array.isArray(banners.value)) {
        localStorage.setItem('coopesq_banners_cache', JSON.stringify(banners.value));
      }
    } catch {}
  } catch (error) {
    console.error('Erro ao carregar dados da Home:', error);
  } finally {
    isLoaded.value = true;
  }
};

watch(activeCategory, async (cat) => {
  try {
    const res = await axios.get(`/api/products?category=${cat}`);
    products.value = res.data.data || [];
  } catch {}
});

onMounted(() => {
  fetchHomeData();
});
</script>
