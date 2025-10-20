<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { Construction } from 'lucide-vue-next';
</script>

<template>
  <Badge
    class="flex max-w-fit items-center gap-2 !rounded-md border border-yellow-500 bg-yellow-600 p-1 px-2 text-xs text-white md:text-sm dark:bg-yellow-500/30"
    >En construction <Construction :size="16"
  /></Badge>
</template>
