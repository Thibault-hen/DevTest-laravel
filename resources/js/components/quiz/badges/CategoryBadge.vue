<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { CategoryData } from '@/types/generated';

const props = defineProps<{ category: CategoryData | null }>();
</script>

<template>
  <Badge
    class="flex items-center gap-2 border border-primary bg-primary/70 p-1 px-2 font-bold text-xs text-white dark:bg-primary/30"
    >{{ props.category?.title }}</Badge
  >
</template>
