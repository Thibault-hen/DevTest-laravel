<script setup lang="ts">
import AppearanceTabs from '@/components/AppearanceTabs.vue';
import NavUser from '@/components/settings/user/NavUser.vue';
import AppLogo from '@/components/shared/AppLogo.vue';
import AppLogoIcon from '@/components/shared/AppLogoIcon.vue';
import Footer from '@/components/shared/Footer.vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import Button from '@/components/ui/button/Button.vue';
import Separator from '@/components/ui/separator/Separator.vue';
import { Toaster } from '@/components/ui/sonner';
import { useAppearance } from '@/composables/useAppearance';
import { urlIsActive } from '@/lib/utils';
import { home, login, logout, quizzes, register } from '@/routes';
import { dashboard } from '@/routes/admin';
import type { BreadcrumbItemType, NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { GraduationCap, House, LayoutGrid, LogIn, LogOut, Menu, UserRoundPlus, X } from 'lucide-vue-next';
import { ref } from 'vue';
import 'vue-sonner/style.css';
interface Props {
  breadcrumbs?: BreadcrumbItemType[];
}

const { getStoredAppearance } = useAppearance();
const page = usePage();

const isOpen = ref(false);

const navItems = [
  { title: 'Accueil', href: home(), icon: House },
  { title: 'Quizz', href: quizzes(), icon: GraduationCap },
] as NavItem[];

const toggleSideNav = (): void => {
  isOpen.value = !isOpen.value;
};

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
});
</script>

<template>
  <Toaster
    :theme="getStoredAppearance() ?? 'system'"
    :closeButton="true"
    position="top-right"
  />
  <div class="relative flex flex-col items-center p-2 lg:justify-center lg:p-4">
    <!-- Backdrop when mobile SideNav is open -->
    <div
      v-if="isOpen"
      class="fixed inset-0 z-40 backdrop-blur-sm lg:hidden"
      @click="toggleSideNav()"
    />

    <header
      class="fixed top-0 z-30 mb-6 w-full border-b bg-transparent px-5 py-2 text-sm backdrop-blur-md not-has-[nav]:hidden"
    >
      <!--Nav desktop-->
      <nav class="flex items-center justify-between lg:justify-around gap-12 p-2">
        <div class="flex gap-2">
          <AppLogo />
          <div class="hidden lg:flex lg:items-center">
            <Link
              v-for="item in navItems"
              :key="item.title"
              :href="item.href"
              :class="[
                'title-font hidden cursor-pointer rounded-[0.375rem] px-5 py-1.5 text-xs leading-normal font-semibold tracking-wide uppercase transition-colors duration-200 lg:flex',
                urlIsActive(item.href, page.url) ? 'text-primary' : 'hover:text-primary',
              ]"
            >
              <component
                :is="item.icon"
                v-if="item.icon"
                :stroke-width="2"
                :class="urlIsActive(item.href, page.url) ? 'text-primary' : 'hover:text-primary'"
                class="mr-2 h-4 w-4"
              />
              {{ item.title }}
            </Link>
            <Link
              v-if="$page.props.auth.user && $page.props.auth.user.is_admin"
              :href="dashboard()"
              class="title-font inline-block cursor-pointer rounded-[0.375rem] px-5 py-1.5 text-xs leading-normal font-semibold tracking-wide uppercase transition-colors duration-200 hover:text-primary"
            >
              Dashboard
            </Link>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <template v-if="!$page.props.auth.user">
            <Link
              :href="login()"
              class="title-font flex cursor-pointer items-center gap-1.5 rounded-[0.375rem] border bg-primary px-3 py-1.5 text-xs leading-normal text-white transition-colors duration-300"
            >
              <LogIn class="h-3 w-3 sm:h-4 sm:w-4" />
              <span class="hidden lg:flex">Connexion</span>
            </Link>
            <Link
              :href="register()"
              class="title-font flex cursor-pointer items-center gap-1.5 rounded-[0.375rem] border px-3 py-1.5 text-xs leading-normal transition-colors duration-300 hover:bg-primary hover:text-white"
            >
              <UserRoundPlus class="h-3 w-3 sm:h-4 sm:w-4" />
              <span class="hidden lg:flex">Inscription</span>
            </Link>
          </template>

          <Separator
            orientation="vertical"
            class="mx-4 hidden !h-6 lg:flex"
            v-if="!$page.props.auth.user"
          />

          <ThemeToggle />

          <Separator
            orientation="vertical"
            class="mx-4 hidden !h-6 lg:flex"
            v-if="$page.props.auth.user"
          />

          <NavUser
            v-if="$page.props.auth.user"
            :user="$page.props.auth.user"
          />

          <!-- Hamburger menu mobile -->
          <Button
            class="flex cursor-pointer rounded-md lg:hidden"
            size="sm"
            @click="toggleSideNav()"
          >
            <Menu v-if="!isOpen" />
            <X v-else />
          </Button>
        </div>
      </nav>
    </header>

    <!--SideNav mobile-->
    <aside
      class="fixed inset-y-0 left-0 m-2 flex h-screen w-3/4 flex-col rounded-lg border bg-background font-bold shadow-2xl transition-transform duration-300 ease-in-out sm:w-1/2 lg:hidden"
      :class="isOpen ? 'translate-x-0' : '-translate-x-120'"
      style="z-index: 9999"
    >
      <div class="border-b p-4">
        <AppLogoIcon />
      </div>
      <div class="my-2.5 flex flex-col gap-1 overflow-y-auto px-2">
        <Link
          v-for="item in navItems"
          :key="item.title"
          :href="item.href"
          :class="[
            'flex cursor-pointer items-center px-5 py-1.5 leading-normal transition-colors duration-300 hover:text-primary',
            urlIsActive(item.href, page.url) ? 'text-primary' : 'hover:text-primary',
          ]"
          @click="toggleSideNav()"
        >
          <component
            :is="item.icon"
            v-if="item.icon"
            :stroke-width="2"
            :class="urlIsActive(item.href, page.url) ? 'text-primary' : 'hover:text-primary'"
            class="mr-2 h-4 w-4"
          />
          {{ item.title }}
        </Link>
        <Link
          v-if="$page.props.auth.user && $page.props.auth.user.is_admin"
          :href="dashboard()"
          class="flex cursor-pointer items-center rounded-[0.375rem] px-5 py-1.5 leading-normal transition-colors duration-300 hover:text-primary"
        >
          <LayoutGrid
            :stroke-width="2"
            class="mr-2 h-4 w-4"
          />

          Dashboard
        </Link>
      </div>
      <div class="flex flex-col gap-1 overflow-y-auto border-t px-2 pt-2">
        <template v-if="!$page.props.auth.user">
          <Link
            :href="login()"
            class="flex cursor-pointer items-center rounded-[0.375rem] bg-primary px-5 py-1.5 leading-normal text-white transition-colors duration-300"
          >
            <LogIn
              :stroke-width="2"
              class="mr-2 h-4 w-4"
            />
            Connexion
          </Link>
          <Link
            :href="register()"
            class="flex cursor-pointer items-center rounded-[0.375rem] px-5 py-1.5 leading-normal transition-colors duration-300"
          >
            <UserRoundPlus
              :stroke-width="2"
              class="mr-2 h-4 w-4"
            />
            Inscription
          </Link>
        </template>
        <Link
          v-if="$page.props.auth.user"
          :href="logout()"
          class="flex cursor-pointer items-center px-5 py-1.5 leading-normal transition-colors duration-300 hover:text-primary"
        >
          <LogOut
            :stroke-width="1"
            class="mr-2 inline-block h-4 w-4 rotate-180"
          />

          Déconnexion
        </Link>
      </div>

      <div class="mt-auto flex w-full justify-center border-t p-6">
        <AppearanceTabs />
      </div>
    </aside>

    <main class="mt-10 w-full p-1 md:p-10 xl:px-20 min-h-screen">
      <Transition
        name="page"
        mode="out-in"
        appear
      >
        <div :key="$page.url">
          <slot />
        </div>
      </Transition>
    </main>
    <div class="w-full md:px-10 xl:px-20">
      <Footer />
    </div>
  </div>
</template>

<style scoped>
.page-enter-active,
.page-leave-active {
  transition: all 0.14s ease;
}

.page-enter-from {
  opacity: 0;
}

.page-enter-to {
  opacity: 1;
}

.page-leave-from {
  opacity: 1;
}

.page-leave-to {
  opacity: 0;
}
</style>
