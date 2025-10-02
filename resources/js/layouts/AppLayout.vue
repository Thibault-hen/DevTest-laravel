<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import NavUser from '@/components/settings/user/NavUser.vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import Separator from '@/components/ui/separator/Separator.vue';
import { dashboard, login, register } from '@/routes';
import type { BreadcrumbItemType } from '@/types';
import { Link } from '@inertiajs/vue3';
interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <div class="flex min-h-screen flex-col items-center p-6 lg:justify-center lg:p-8">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-between gap-4">
                <div class="inline-block gap-2">
                    <AppLogo />
                </div>
                <div class="flex items-center gap-2">
                    <Link
                        v-if="$page.props.auth.user && $page.props.auth.user.is_admin"
                        :href="dashboard()"
                        class="inline-block cursor-pointer rounded-sm border px-5 py-1.5 text-sm leading-normal transition-colors duration-300 hover:bg-primary hover:text-white"
                    >
                        Dashboard
                    </Link>
                    <template v-if="!$page.props.auth.user">
                        <Link
                            :href="login()"
                            class="inline-block cursor-pointer rounded-sm border bg-primary px-5 py-1.5 text-sm leading-normal text-white transition-colors duration-300"
                        >
                            Log in
                        </Link>
                        <Link
                            :href="register()"
                            class="inline-block cursor-pointer rounded-sm border px-5 py-1.5 text-sm leading-normal transition-colors duration-300 hover:bg-primary hover:text-white"
                        >
                            Register
                        </Link>
                    </template>
                    <Separator orientation="vertical" class="!h-6" />
                    <NavUser v-if="$page.props.auth.user" :user="$page.props.auth.user" />
                    <ThemeToggle class="" />
                </div>
            </nav>
        </header>

        <main class="flex-1">
            <slot />
        </main>
    </div>
</template>
