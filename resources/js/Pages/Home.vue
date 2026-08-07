<template>
  <div>
    <HeroSection :hero-banner="heroBanner" @scroll-to="scrollTo" />
    <AboutSection :settings="settingsStore.general" />
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
import AboutSection from '../Components/Home/AboutSection.vue';
import DifferentialsSection from '../Components/Home/DifferentialsSection.vue';
import ProductsSection from '../Components/Home/ProductsSection.vue';
import PartnersSection from '../Components/Home/PartnersSection.vue';
import TestimonialsSection from '../Components/Home/TestimonialsSection.vue';
import BlogSection from '../Components/Home/BlogSection.vue';
import CtaBannerSection from '../Components/Home/CtaBannerSection.vue';

const settingsStore = useSettingsStore();

const differentials = ref([]);
const products = ref([]);
const partners = ref([]);
const posts = ref([]);
const testimonials = ref([]);
const heroBanner = ref({});
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
    differentials.value = diffRes.data;
    products.value = prodRes.data.data || [];
    partners.value = partRes.data;
    posts.value = (postRes.data.data || []).slice(0, 3);
    testimonials.value = testRes.data;
    if (banRes.data.length > 0) heroBanner.value = banRes.data[0];
  } catch (error) {
    console.error('Erro ao carregar dados da Home:', error);
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
