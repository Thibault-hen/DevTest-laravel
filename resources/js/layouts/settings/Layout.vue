<script setup lang="ts">
import Heading from '@/components/shared/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { toUrl, urlIsActive } from '@/lib/utils';
import { appearance } from '@/routes';
import { edit as editPassword } from '@/routes/password';
import { edit } from '@/routes/profile';
import { show } from '@/routes/two-factor';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';

const sidebarNavItems: NavItem[] = [
  {
    title: 'Profile',
    href: edit(),
  },
  {
    title: 'Mot de passe',
    href: editPassword(),
  },
  {
    title: 'Authentification à deux facteurs',
    href: show(),
  },
  {
    title: 'Apparence',
    href: appearance(),
  },
];

const currentPath = typeof window !== undefined ? window.location.pathname : '';
</script>

<template>
  <div class="px-4 py-6">
    <Heading
      title="Paramètres"
      description="Gérez votre profil et les paramètres de votre compte"
    />

    <div class="flex flex-col lg:flex-row lg:space-x-12 justify-center">
      <aside class="w-full max-w-xl lg:w-48">
        <nav class="flex flex-col space-y-1 space-x-0">
          <Button
            v-for="item in sidebarNavItems"
            :key="toUrl(item.href)"
            :variant="urlIsActive(item.href, currentPath) ? 'primary' : 'ghost'"
            class="w-full justify-start"
            as-child
          >
            <Link :href="item.href">
              {{ item.title }}
            </Link>
          </Button>
        </nav>
      </aside>

      <Separator class="my-6 lg:hidden" />

      <div class="flex-1 md:max-w-2xl">
        <section class="max-w-xl space-y-12">
          <slot />
        </section>
      </div>
    </div>
  </div>
</template>
