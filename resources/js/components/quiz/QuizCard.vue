<script lang="ts" setup>
import StarRating from '@/components/quiz/StarRating.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import { useAppearance } from '@/composables/useAppearance';
import { COLORS } from '@/constants/colors';
import { quiz } from '@/routes';
import { QuizData } from '@/types/generated';
import { Link } from '@inertiajs/vue3';
import { Construction, Gauge, Timer } from 'lucide-vue-next';
import Badge from '../ui/badge/Badge.vue';

const props = defineProps<{ quiz: QuizData }>();
const { isDark } = useAppearance();
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
          <span
            class="flex max-w-fit items-center gap-2 rounded-md border p-1 px-2 text-xs text-white shadow drop-shadow md:text-sm"
            :style="{
              backgroundColor: isDark()
                ? `${props.quiz.difficulty?.color ?? COLORS.DEFAULT}10`
                : (props.quiz.difficulty?.color ?? COLORS.DEFAULT),
              borderColor: props.quiz.difficulty?.color ?? COLORS.DEFAULT,
              color: isDark() ? (props.quiz.difficulty?.color ?? COLORS.DEFAULT) : '',
            }"
            ><Gauge :size="16" />{{ props.quiz.difficulty?.level }}
          </span>

          <Badge
            class="flex items-center gap-2 border border-primary bg-primary/70 p-1 px-2 text-xs text-white md:text-sm dark:bg-primary/30"
            >{{ props.quiz.category?.name }}</Badge
          >
        </div>

        <div v-else>
          <span
            class="flex max-w-fit items-center gap-2 !rounded-md border border-yellow-500 bg-yellow-600 p-1 px-2 text-xs text-white md:text-sm dark:bg-yellow-500/30"
            >En construction <Construction :size="16"
          /></span>
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
