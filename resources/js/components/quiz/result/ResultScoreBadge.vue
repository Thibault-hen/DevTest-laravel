<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';

const props = defineProps<{ score: number }>();
</script>

<template>
  <Badge
    class="font-bold text-sm leading-none inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-muted text-black/50 dark:text-white border border-muted-foreground/20 dark:bg-white/5"
  >
    {{ props.score }}
  </Badge>
</template>
