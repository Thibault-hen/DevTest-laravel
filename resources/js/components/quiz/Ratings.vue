<script setup lang="ts">
import StarRating from '@/components/quiz/StarRating.vue';
import UserAvatar from '@/components/settings/user/UserAvatar.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import { RatingData } from '@/types/generated';

const props = defineProps<{
  ratings: RatingData[];
}>();
</script>

<template>
  <div
    class="border-b pb-4 last:border-none space-y-4"
    v-for="rating in props.ratings"
    :key="rating.id"
  >
    <div class="flex items-center gap-4">
      <UserAvatar
        v-if="rating.user"
        :user="rating.user"
      />
      <div class="flex flex-col gap-2">
        <div class="flex sm:items-center gap-2 flex-col sm:flex-row">
          <span class="font-bold text-xs sm:text-sm lg:text-base">{{ rating.user?.name }}</span>
          <span class="hidden sm:flex">-</span>
          <Badge
            class="border border-primary bg-primary/70 p-1 px-2 text-xs text-white md:text-sm dark:bg-primary/30"
            >{{ rating.user?.specialization }}</Badge
          >
        </div>
        <div class="flex gap-4 items-center">
          <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ new Date(rating.created_at).toLocaleDateString() }}
          </span>
          <StarRating
            :rating="rating.score"
            :count="1"
          />
        </div>
      </div>
    </div>
    <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
      {{ rating.comment }}
    </p>
  </div>
</template>
