<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner';
import { useAppearance } from '@/composables/useAppearance';
import 'vue-sonner/style.css';
import AdminSidebarLayout from './admin/AdminSidebarLayout.vue';

const { getStoredAppearance } = useAppearance();
</script>

<template>
  <Toaster
    :theme="getStoredAppearance() ?? 'system'"
    :closeButton="true"
    position="bottom-center"
  />
  <AdminSidebarLayout>
    <template #header-actions>
      <slot name="header-actions" />
    </template>
    <slot />
  </AdminSidebarLayout>
</template>
