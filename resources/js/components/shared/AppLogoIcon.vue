<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
  inheritAttrs: false,
});

interface Props {
  className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
  <h1
    href="/"
    class="title-font flex cursor-pointer items-center gap-1 text-base font-semibold tracking-wider uppercase transition-colors duration-200 hover:text-primary"
  >
    <img
      src="/assets/logo.svg"
      alt="Inter font logo"
      class="size-6"
    />
    Devtest
  </h1>
</template>
