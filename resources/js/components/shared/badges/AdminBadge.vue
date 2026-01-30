<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { UserData } from '@/types/generated';

const props = defineProps<{ user: UserData | null }>();
</script>

<template>
  <Badge
    v-if="props.user?.is_admin"
    class="flex bg-primary text-white border uppercase items-center gap-2 p-0.5 px-2 font-bold text-xs"
    >ADMIN</Badge
  >
</template>
