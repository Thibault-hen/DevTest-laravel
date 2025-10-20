<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { CategoryData } from '@/types/generated';

const props = defineProps<{ category: CategoryData }>();
</script>

<template>
  <Badge
    class="flex items-center gap-2 border border-primary bg-primary/70 p-1 px-2 text-xs text-white md:text-sm dark:bg-primary/30"
    >{{ props.category?.name }}</Badge
  >
</template>
