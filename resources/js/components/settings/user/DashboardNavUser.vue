<script setup lang="ts">
import UserMenuContent from '@/components/settings/user/UserMenuContent.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { usePage } from '@inertiajs/vue3';
import { ChevronsUpDownIcon } from 'lucide-vue-next';
import UserAvatar from './UserAvatar.vue';

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
  <div class="flex items-center gap-2 w-full">
    <DropdownMenu>
      <DropdownMenuTrigger as-child>
        <div class="flex items-center w-full text-left gap-2 font-medium cursor-pointer group/dropdown">
          <UserAvatar :user="user" />
          <div class="flex-1 flex-col flex group-data-[collapsible=icon]:hidden">
            <span class="uppercase text-xs font-bold leading-none">
              {{ user?.name }}
            </span>
            <span class="text-[0.725rem] truncate text-muted-foreground">{{ user?.email }}</span>
          </div>
          <ChevronsUpDownIcon
            :size="16"
            class="group-hover/dropdown:text-primary transition-colors duration-200"
          />
        </div>
      </DropdownMenuTrigger>
      <DropdownMenuContent class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg">
        <UserMenuContent :user="user" />
      </DropdownMenuContent>
    </DropdownMenu>
  </div>
</template>
