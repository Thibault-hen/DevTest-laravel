<script setup lang="ts">
import AppContent from '@/components/admin/AppContent.vue';
import AppShell from '@/components/admin/AppShell.vue';
import AppSidebar from '@/components/admin/AppSidebar.vue';
import AppSidebarHeader from '@/components/admin/AppSidebarHeader.vue';
import { dashboard } from '@/routes/admin';
import type { BreadcrumbItemType } from '@/types';
import { type BreadcrumbItem } from '@/types';

interface Props {
  breadcrumbs?: BreadcrumbItemType[];
}
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
];

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
});
</script>

<template>
  <div>
    <AppShell variant="sidebar">
      <AppSidebar />
      <AppContent
        variant="sidebar"
        class="overflow-x-hidden"
      >
        <AppSidebarHeader :breadcrumbs="breadcrumbs">
          <template #actions>
            <slot name="header-actions" />
          </template>
        </AppSidebarHeader>
        <slot />
      </AppContent>
    </AppShell>
  </div>
</template>
