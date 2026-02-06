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
      <nav class="flex items-center justify-between lg:justify-around gap-6 p-2.5">
        <div class="flex items-center gap-8">
          <AppLogo />

          <div class="hidden lg:flex items-center gap-1">
            <Link
              v-for="item in navItems"
              :key="item.title"
              :href="item.href"
              :class="[
                'border-b-2 border-transparent flex font-medium items-center gap-2 px-4 py-2 text-sm uppercase tracking-wide transition-colors',
                urlIsActive(item.href, page.url) ? 'text-primary !border-primary' : 'hover:text-primary',
              ]"
            >
              <component
                :is="item.icon"
                v-if="item.icon"
                class="w-4 h-4"
                :stroke-width="2"
              />
              {{ item.title }}
            </Link>

            <Link
              v-if="$page.props.auth.user?.is_admin"
              :href="dashboard()"
              class="flex items-center px-4 py-2 text-sm font-medium uppercase tracking-wide rounded-lg transition-colors hover:text-primary"
            >
              Dashboard
            </Link>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <template v-if="!$page.props.auth.user">
            <Link
              :href="login()"
              class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded bg-primary text-white transition-all hover:bg-primary/90"
            >
              <LogIn class="w-4 h-4" />
              <span class="hidden sm:inline">Connexion</span>
            </Link>

            <Link
              :href="register()"
              class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded border border-primary text-primary transition-all hover:bg-primary hover:text-white"
            >
              <UserRoundPlus class="w-4 h-4" />
              <span class="hidden sm:inline">Inscription</span>
            </Link>

            <Separator
              orientation="vertical"
              class="hidden lg:block h-6 mx-2"
            />
          </template>

          <ThemeToggle />

          <template v-if="$page.props.auth.user">
            <Separator
              orientation="vertical"
              class="hidden lg:block h-6 mx-2"
            />
            <NavUser :user="$page.props.auth.user" />
          </template>

          <Button
            variant="ghost"
            size="icon"
            class="lg:hidden"
            @click="toggleSideNav()"
          >
            <Menu
              v-if="!isOpen"
              class="w-5 h-5"
            />
            <X
              v-else
              class="w-5 h-5"
            />
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
