<script setup lang="ts">
import AppLogo from '@/components/shared/AppLogo.vue';
const appName = import.meta.env.VITE_APP_NAME || 'DevTest';
</script>

<template>
  <footer
    class="flex justify-between items-center mt-10 w-full border-t bg-background/70 px-2 md:px-12 py-10 text-center text-sm text-muted-foreground backdrop-blur-md"
  >
    <span class="text-xs md:text-sm">&copy; {{ new Date().getFullYear() }} {{ appName }}. Tous droits réservés.</span>
    <AppLogo />
  </footer>
</template>
