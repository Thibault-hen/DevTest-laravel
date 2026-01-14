<script setup lang="ts">
import ThemeToggle from '@/components/ThemeToggle.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth.user;

withDefaults(
  defineProps<{
    breadcrumbs?: BreadcrumbItemType[];
  }>(),
  {
    breadcrumbs: () => [],
  },
);
</script>

<template>
  <header
    class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
  >
    <div class="flex items-center gap-2 justify-between w-full">
      <div class="flex items-center gap-2">
        <SidebarTrigger class="-ml-1" />
        <span> Bienvenue, {{ user?.name }} </span>
      </div>
      <div class="flex items-center gap-2">
        <slot name="actions" />
        <ThemeToggle />
      </div>
    </div>
  </header>
</template>
