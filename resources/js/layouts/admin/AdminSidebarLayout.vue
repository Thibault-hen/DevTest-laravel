<script setup lang="ts">
import AppContent from '@/components/admin/AppContent.vue';
import AppShell from '@/components/admin/AppShell.vue';
import AppSidebar from '@/components/admin/AppSidebar.vue';
import AppSidebarHeader from '@/components/admin/AppSidebarHeader.vue';
import { dashboard } from '@/routes/admin';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
];
</script>

<template>
  <div>
    <AppShell variant="sidebar">
      <AppSidebar />
      <AppContent
        variant="sidebar"
        class="max-h-screen overflow-y-auto"
      >
        <AppSidebarHeader :breadcrumbs="breadcrumbs">
          <template #actions>
            <slot name="header-actions" />
          </template>
        </AppSidebarHeader>
        <div class="dark:bg-secondary2 min-h-screen">
          <slot />
        </div>
      </AppContent>
    </AppShell>
  </div>
</template>
