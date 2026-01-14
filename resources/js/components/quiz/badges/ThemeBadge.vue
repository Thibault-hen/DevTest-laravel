<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { ThemeData } from '@/types/generated';
import { Tag } from 'lucide-vue-next';

const props = defineProps<{ themes: ThemeData[] }>();
console.log(props.themes);
</script>

<template>
  <Badge
    v-for="theme in props.themes"
    :key="theme.id"
    variant="outline"
    class="flex items-center gap-2 border p-1 px-2 text-xs md:text-sm"
  >
    <Tag :size="16" />{{ theme.title }}
  </Badge>
</template>
