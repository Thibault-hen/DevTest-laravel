<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <Link
    href="/"
    class="title-font flex cursor-pointer items-center gap-1 text-sm sm:text-lg font-semibold tracking-wider uppercase transition-colors duration-200 hover:text-primary"
  >
    <img
      src="/assets/logo.svg"
      alt="Inter font logo"
      class="size-6"
    />
    Devtest
  </Link>
</template>
