<script setup lang="ts">
interface Props {
  title: string;
  description?: string;
}

defineProps<Props>();
</script>

<template>
  <div class="group relative mb-8 space-y-2">
    <h2 class="text-lg md:text-2xl font-bold tracking-tight">
      {{ title }}
    </h2>

    <p
      v-if="description"
      class="max-w-2xl animate-in text-sm leading-relaxed text-muted-foreground duration-500 fade-in slide-in-from-left-2"
    >
      {{ description }}
    </p>

    <div
      class="relative mt-4 h-0.5 w-full overflow-hidden rounded-full bg-gradient-to-r from-transparent via-gray-400 to-transparent dark:via-primary/30"
    >
      <div
        class="absolute inset-0 translate-x-[-100%] bg-gradient-to-r from-transparent via-primary to-transparent"
      ></div>
    </div>
  </div>
</template>
