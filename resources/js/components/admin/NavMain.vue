<script setup lang="ts">
import {
  SidebarGroup,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar';
import { urlIsActive } from '@/lib/utils';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{
  mainItems: NavItem[];
  userItems: NavItem[];
}>();

const page = usePage();
</script>

<template>
  <SidebarGroup>
    <SidebarGroupLabel>Dashboard</SidebarGroupLabel>
    <SidebarMenu>
      <SidebarMenuItem
        v-for="item in mainItems"
        :key="item.title"
      >
        <SidebarMenuButton
          as-child
          :is-active="urlIsActive(item.href, page.url)"
          :tooltip="item.title"
        >
          <Link :href="item.href">
            <component :is="item.icon" />
            <span>{{ item.title }}</span>
          </Link>
        </SidebarMenuButton>
      </SidebarMenuItem>
    </SidebarMenu>
  </SidebarGroup>
  <SidebarGroup>
    <SidebarGroupLabel>Utilisateurs</SidebarGroupLabel>
    <SidebarMenu>
      <SidebarMenuItem
        v-for="item in userItems"
        :key="item.title"
      >
        <SidebarMenuButton
          as-child
          :is-active="urlIsActive(item.href, page.url)"
          :tooltip="item.title"
        >
          <Link :href="item.href">
            <component :is="item.icon" />
            <span>{{ item.title }}</span>
          </Link>
        </SidebarMenuButton>
      </SidebarMenuItem>
    </SidebarMenu>
  </SidebarGroup>
</template>
