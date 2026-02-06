<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import AppLogo from '../shared/AppLogo.vue';
const isLoading = ref(false);

const body = document.querySelector('body') as HTMLBodyElement;

onMounted(() => {
  router.on('start', () => {
    isLoading.value = true;
    body.style.overflow = 'hidden';
  });
  router.on('finish', () => {
    isLoading.value = false;
    body.style.overflow = 'auto';
  });
});
</script>

<template>
  <Transition name="loader-fade">
    <div
      v-if="isLoading"
      class="fixed inset-0 z-50 flex items-center justify-center overflow-hidden"
    >
      <div class="absolute inset-0 bg-white/30 dark:bg-black/30 backdrop-blur-xs"></div>
      <div class="relative z-10 flex items-center gap-2 flex-col">
        <AppLogo />
        <div class="loader" />
      </div>
    </div>
  </Transition>
</template>

<style scoped>
.loader {
  width: 25px;
  aspect-ratio: 1;
  --c: no-repeat linear-gradient(var(--color-primary) 0 0);
  background: var(--c), var(--c), var(--c);
  animation:
    l18-1 1s infinite,
    l18-2 1s infinite;
}
@keyframes l18-1 {
  0%,
  100% {
    background-size: 20% 100%;
  }
  33%,
  66% {
    background-size: 20% 20%;
  }
}
@keyframes l18-2 {
  0%,
  33% {
    background-position:
      0 0,
      50% 50%,
      100% 100%;
  }
  66%,
  100% {
    background-position:
      100% 0,
      50% 50%,
      0 100%;
  }
}

.loader-fade-enter-active,
.loader-fade-leave-active {
  transition: opacity 0.1s ease;
}

.loader-fade-enter-from,
.loader-fade-leave-to {
  opacity: 0;
}
</style>
