<script setup lang="ts">
interface Props {
  title: string;
}

defineProps<Props>();
</script>

<template>
  <div class="group relative space-y-2">
    <span class="text-sm md:text-base font-bold tracking-tight">
      {{ title }}
    </span>

    <div
      class="relative mt-4 h-0.5 w-full overflow-hidden rounded-full bg-gradient-to-r from-transparent via-gray-400 to-transparent dark:via-primary/30"
    >
      <div
        class="absolute inset-0 translate-x-[-100%] bg-gradient-to-r from-transparent via-primary to-transparent opacity-0 transition-all duration-700 group-hover:translate-x-[100%] group-hover:opacity-100"
      ></div>
    </div>
  </div>
</template>
