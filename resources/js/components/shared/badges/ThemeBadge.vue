<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { ThemeData } from '@/types/generated';
import { Tag } from 'lucide-vue-next';

const props = defineProps<{ theme: ThemeData }>();
</script>

<template>
  <Badge
    variant="outline"
    class="flex items-center gap-2 border p-1 px-2 text-xs md:text-sm font-bold"
  >
    <Tag :size="16" />{{ props.theme.title }}
  </Badge>
</template>
