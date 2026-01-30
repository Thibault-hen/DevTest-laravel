<script setup lang="ts">
import NavMain from '@/components/admin/NavMain.vue';
import DashboardNavUser from '@/components/settings/user/DashboardNavUser.vue';
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar';
import { categories, dashboard, difficulties, quizzes, results, specializations, themes, users } from '@/routes/admin';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Contact, Gauge, GraduationCap, LayoutGridIcon, NotebookText, Tags, Users2 } from 'lucide-vue-next';
const mainNavItems: NavItem[] = [
  {
    title: "Vue d'ensemble",
    href: dashboard(),
    icon: LayoutGridIcon,
  },
  {
    title: 'Quiz',
    href: quizzes(),
    icon: GraduationCap,
  },
  {
    title: 'Thèmes',
    href: themes(),
    icon: Tags,
  },
  {
    title: 'Catégories',
    href: categories(),
    icon: Contact,
  },
  {
    title: 'Difficultés',
    href: difficulties(),
    icon: Gauge,
  },
  {
    title: 'Spécialisations',
    href: specializations(),
    icon: GraduationCap,
  },
];

const usersNavItems: NavItem[] = [
  {
    title: 'Résultats',
    href: results(),
    icon: NotebookText,
  },
  {
    title: 'Gestion des utilisateurs',
    href: users(),
    icon: Users2,
  },
];
</script>

<template>
  <Sidebar
    collapsible="icon"
    variant="sidebar"
  >
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton
            size="lg"
            as-child
          >
            <Link
              href="/"
              class="flex items-center gap-2 group-data-[collapsible=icon]:justify-center"
            >
              <img
                src="/assets/logo.svg"
                alt="DevTest logo"
                class="size-6 shrink-0"
              />
              <span
                class="title-font text-lg font-semibold tracking-wider uppercase transition-colors duration-200 group-data-[collapsible=icon]:hidden"
              >
                Devtest
              </span>
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <NavMain
        :main-items="mainNavItems"
        :user-items="usersNavItems"
      />
    </SidebarContent>

    <SidebarFooter class="border-t pt-4 p-2">
      <DashboardNavUser />
    </SidebarFooter>
  </Sidebar>
  <slot />
</template>
