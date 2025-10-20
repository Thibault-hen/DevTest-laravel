<script lang="ts" setup>
import CategoryBadge from '@/components/quiz/badges/CategoryBadge.vue';
import DifficultyBadge from '@/components/quiz/badges/DifficultyBadge.vue';
import UnavailableBadge from '@/components/quiz/badges/UnavailableBadge.vue';
import StarRating from '@/components/quiz/rating/StarRating.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import { quiz } from '@/routes';
import { QuizData } from '@/types/generated';
import { Link } from '@inertiajs/vue3';
import { Timer } from 'lucide-vue-next';

const props = defineProps<{ quiz: QuizData }>();
</script>

<template>
  <Link :href="quiz(props.quiz.slug)">
    <Card
      class="w-full min-w-[340px] cursor-pointer pb-0 transition-all duration-200 ease-in-out hover:scale-[1.03] hover:border-primary"
    >
      <CardHeader class="flex">
        <div class="flex items-center justify-center gap-2">
          <img
            v-if="props.quiz.image_url"
            :src="`/${props.quiz.image_url}`"
            :alt="props.quiz.image_text || 'Quiz image'"
            class="flex h-6 rounded"
          />
          <CardTitle class="text-sm md:text-base">{{ props.quiz.title }}</CardTitle>
        </div>
      </CardHeader>

      <CardContent class="flex flex-col gap-2.5 font-bold">
        <div
          v-if="props.quiz.is_published"
          class="flex gap-2"
        >
          <DifficultyBadge
            v-if="props.quiz.difficulty"
            :difficulty="props.quiz.difficulty"
          />

          <CategoryBadge
            v-if="props.quiz.category"
            :category="props.quiz.category"
          />
        </div>

        <div v-else>
          <UnavailableBadge />
        </div>

        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2 text-sm">
            <Timer class="h-4 w-4 text-muted-foreground" />
            <div>
              <p class="text-xs text-muted-foreground">Durée</p>
              <p class="font-semibold">{{ props.quiz.duration }} min</p>
            </div>
          </div>

          <StarRating
            v-if="props.quiz.average_rating"
            :rating="props.quiz.average_rating ?? 0"
            :count="props.quiz.ratings_count ?? 0"
          />
        </div>
      </CardContent>

      <CardFooter
        class="flex items-center justify-between rounded-br-sm rounded-bl-sm bg-muted p-2 text-sm text-muted-foreground"
      >
        <span>Par {{ props.quiz.author?.name }}</span>
        <span>{{ props.quiz.created_at }}</span>
      </CardFooter>
    </Card>
  </Link>
</template>
