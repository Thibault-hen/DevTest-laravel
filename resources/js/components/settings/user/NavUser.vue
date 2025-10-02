<script setup lang="ts">
import UserMenuContent from '@/components/settings/user/UserMenuContent.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { usePage } from '@inertiajs/vue3';
import UserAvatar from './UserAvatar.vue';

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <UserAvatar :user="user" />
        </DropdownMenuTrigger>
        <DropdownMenuContent class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg">
            <UserMenuContent :user="user" />
        </DropdownMenuContent>
    </DropdownMenu>
</template>
