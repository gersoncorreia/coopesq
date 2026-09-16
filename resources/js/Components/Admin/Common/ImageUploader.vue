<template>
  <div class="space-y-1.5">
    <div class="flex items-center justify-between">
      <label v-if="label" class="block text-xs font-semibold text-zinc-700">
        {{ label }}
      </label>
      <button 
        v-if="modelValue" 
        type="button" 
        @click="$emit('update:modelValue', '')" 
        class="text-[11px] text-rose-600 hover:text-rose-700 font-semibold cursor-pointer"
      >
        Remover
      </button>
    </div>

    <!-- Upload Card Box -->
    <div 
      class="relative rounded-lg border border-dashed transition-all duration-200 bg-zinc-50/60 hover:bg-zinc-50 overflow-hidden group"
      :class="modelValue ? 'border-zinc-300' : 'border-zinc-300/80 hover:border-emerald-600'"
    >
      <!-- Preview Area -->
      <div v-if="modelValue && !imgLoadFailed" class="h-28 w-full p-2.5 flex items-center justify-center bg-zinc-100/50">
        <img 
          :src="modelValue" 
          alt="Preview" 
          class="max-h-full max-w-full object-contain drop-shadow-xs"
          @error="imgLoadFailed = true"
          @load="imgLoadFailed = false"
        />
      </div>

      <!-- Empty State / Upload Trigger -->
      <label 
        v-else 
        class="h-28 w-full flex flex-col items-center justify-center p-3 text-center cursor-pointer select-none"
      >
        <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center mb-1.5 group-hover:scale-105 transition-transform">
          <Upload :size="15" />
        </div>
        <span class="text-xs font-medium text-zinc-700 group-hover:text-emerald-700 transition-colors">
          Enviar Arquivo
        </span>
        <span class="text-[10px] text-zinc-400 mt-0.5">
          PNG, JPG, SVG ou ICO
        </span>
        <input 
          type="file" 
          accept="image/png, image/jpeg, image/webp, image/svg+xml, image/x-icon, .ico" 
          class="hidden" 
          @change="handleFileSelect"
        />
      </label>

      <!-- Change image button overlay on hover when an image is present -->
      <label 
        v-if="modelValue && !isUploading" 
        class="absolute inset-x-0 bottom-0 py-1 bg-zinc-900/70 backdrop-blur-xs text-white text-[10px] font-medium text-center cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity"
      >
        Trocar imagem
        <input 
          type="file" 
          accept="image/png, image/jpeg, image/webp, image/svg+xml, image/x-icon, .ico" 
          class="hidden" 
          @change="handleFileSelect"
        />
      </label>

      <!-- Uploading Spinner Overlay -->
      <div 
        v-if="isUploading" 
        class="absolute inset-0 bg-white/90 backdrop-blur-xs flex flex-col items-center justify-center text-emerald-800 text-[11px] font-medium gap-1 z-10"
      >
        <div class="w-4 h-4 border-2 border-emerald-600 border-t-transparent rounded-full animate-spin"></div>
        <span>Enviando...</span>
      </div>
    </div>

    <!-- Error message -->
    <p v-if="errorMessage" class="text-[11px] font-medium text-rose-600">
      {{ errorMessage }}
    </p>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import { Upload } from 'lucide-vue-next';

const props = defineProps({
  modelValue: { type: String, default: '' },
  label: { type: String, default: 'Imagem' }
});

const emit = defineEmits(['update:modelValue']);
const isUploading = ref(false);
const errorMessage = ref('');
const imgLoadFailed = ref(false);

watch(() => props.modelValue, () => {
  imgLoadFailed.value = false;
});

const handleFileSelect = async (event) => {
  const file = event.target.files?.[0];
  if (!file) return;

  errorMessage.value = '';

  const allowedTypes = [
    'image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 
    'image/x-icon', 'image/vnd.microsoft.icon'
  ];
  const isIcoExt = file.name.toLowerCase().endsWith('.ico');
  if (!allowedTypes.includes(file.type) && !isIcoExt) {
    errorMessage.value = 'Formato inválido! Use apenas JPG, PNG, WebP, SVG ou ICO.';
    event.target.value = '';
    return;
  }

  if (file.size > 4 * 1024 * 1024) {
    errorMessage.value = 'O arquivo excede o limite máximo permitido de 4MB.';
    event.target.value = '';
    return;
  }

  const formData = new FormData();
  formData.append('file', file);

  isUploading.value = true;
  try {
    const token = localStorage.getItem('admin_token');
    const res = await axios.post('/api/admin/upload', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'Authorization': `Bearer ${token}`
      }
    });

    if (res.data?.url) {
      emit('update:modelValue', res.data.url);
    }
  } catch (err) {
    errorMessage.value = err.response?.data?.message || 'Falha ao fazer upload da imagem.';
  } finally {
    isUploading.value = false;
    event.target.value = '';
  }
};
</script>
