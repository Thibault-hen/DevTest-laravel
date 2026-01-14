<script setup lang="ts">
import AppContent from '@/components/admin/AppContent.vue';
import AppShell from '@/components/admin/AppShell.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
  breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
});
</script>

<template>
  <AppShell class="flex-col">
    <AppContent>
      <slot />
    </AppContent>
  </AppShell>
</template>
