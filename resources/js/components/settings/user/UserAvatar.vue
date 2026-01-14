<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import { User } from '@/types/index';
import { computed } from 'vue';

interface Props {
  user: User;
}

const props = defineProps<Props>();

const { getInitials } = useInitials();

// Compute whether we should show the avatar image
const showAvatar = computed(() => props?.user?.avatar && props?.user?.avatar !== '');
</script>

<template>
  <Avatar class="h-8 w-8 cursor-pointer overflow-hidden rounded-full border border-border hover:border-primary">
    <AvatarImage
      v-if="showAvatar"
      :src="`/${props.user.avatar}`"
      :alt="props.user.name"
    />
    <AvatarFallback class="bg-transparent text-black dark:text-white">
      {{ getInitials(props.user?.name) }}
    </AvatarFallback>
  </Avatar>
</template>
