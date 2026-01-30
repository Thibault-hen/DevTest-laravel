<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';

const props = defineProps<{ count: number }>();
</script>

<template>
  <Badge
    :class="[
      'inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium',
      props.count >= 1
        ? 'bg-primary text-white shadow-lg shadow-primary/30'
        : 'bg-muted text-black/50 dark:text-white border border-muted-foreground/20 dark:bg-white/5',
    ]"
  >
    <span class="font-bold text-sm leading-none">{{ props.count }}</span>
    <span class="font-medium tracking-wide">Quiz</span>
  </Badge>
</template>
