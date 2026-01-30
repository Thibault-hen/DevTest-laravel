<script setup lang="ts">
import StarRating from '@/components/quiz/rating/StarRating.vue';
import UserRatingAvatar from '@/components/settings/user/UserRatingAvatar.vue';
import UserRoleBadge from '@/components/shared/badges/UserRoleBadge.vue';
import ContentTitle from '@/components/shared/ContentTitle.vue';
import Card from '@/components/ui/card/Card.vue';
import { RatingData } from '@/types/generated';

const props = defineProps<{
  ratings: RatingData[];
}>();
</script>

<template>
  <Card class="p-4">
    <ContentTitle title="Avis des développeurs ayant passé ce quiz" />
    <div
      v-if="props.ratings"
      class="border-b pb-4 last:border-none space-y-4"
      v-for="rating in props.ratings"
      :key="rating.id"
    >
      <div class="flex items-center gap-4">
        <UserRatingAvatar
          v-if="rating.user"
          :user="rating.user"
        />
        <div class="flex flex-col gap-2">
          <div class="flex sm:items-center gap-2 flex-col sm:flex-row">
            <span class="font-bold text-xs sm:text-sm lg:text-base">{{ rating.user?.name }}</span>
            <span
              class="hidden sm:flex"
              v-if="rating.user?.specialization"
              >-</span
            >
            <UserRoleBadge
              v-if="rating.user?.specialization"
              :specialization="rating.user.specialization"
            />
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
    <span
      v-else
      class="text-sm text-muted-foreground text-center"
      >Aucune évaluation pour ce quiz.</span
    >
  </Card>
</template>
