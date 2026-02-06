<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { UserData } from '@/types/generated';

const props = defineProps<{ user: UserData | null }>();
</script>

<template>
  <Badge
    class="flex bg-green-500/30 text-green-800 dark:bg-green-500/10 border border-green-500 items-center gap-2 p-1 px-2 font-bold text-xs"
    :class="{
      'bg-red-500/30 text-red-800 dark:bg-red-500/10 border border-red-500': !props.user?.two_factor_confirmed_at,
    }"
    >{{ props.user?.two_factor_confirmed_at ? 'Activé' : 'Désactivé' }}</Badge
  >
</template>
