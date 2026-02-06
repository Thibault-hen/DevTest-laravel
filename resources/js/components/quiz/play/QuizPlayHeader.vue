<script setup lang="ts">
import CategoryBadge from '@/components/shared/badges/CategoryBadge.vue';
import DifficultyBadge from '@/components/shared/badges/DifficultyBadge.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Progress from '@/components/ui/progress/Progress.vue';
import { QuizPlayData } from '@/types/generated';
import { Clock, Image as ImageIcon } from 'lucide-vue-next';

const props = defineProps<{
  quiz: QuizPlayData;
  currentQuestionIndex: number;
  totalQuestions: number;
  progress: number;
}>();
</script>

<template>
  <div class="space-y-4">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
      <div class="space-y-1">
        <div class="flex flex-wrap items-center gap-2">
          <DifficultyBadge
            v-if="props.quiz.difficulty"
            :difficulty="props.quiz.difficulty"
            class="shadow-sm"
          />
          <CategoryBadge
            v-if="props.quiz.category"
            :category="props.quiz.category"
            class="shadow-sm"
          />
          <Badge
            variant="secondary"
            class="gap-1.5 px-2.5 shadow-sm border border-border rounded-md py-1"
          >
            <Clock class="h-3.5 w-3.5" />
            <span>~{{ props.quiz.duration }} min</span>
          </Badge>
        </div>

        <h1 class="text-xl font-bold tracking-tight md:text-2xl flex items-center gap-2 mt-2">
          <img
            v-if="quiz.image_url"
            :src="`/${quiz.image_url}`"
            :alt="quiz.image_text || 'Quiz image'"
            class="h-10 w-10 rounded-md object-cover"
          />
          <ImageIcon
            v-else
            class="h-5 w-5 text-muted-foreground mr-1"
          />
          {{ props.quiz.title }}
        </h1>
      </div>

      <div class="flex flex-col items-end gap-2 min-w-[200px]">
        <span class="text-xs font-medium text-muted-foreground uppercase tracking-wider">
          Progression {{ currentQuestionIndex + 1 }} / {{ totalQuestions }}
        </span>
        <Progress
          :model-value="progress"
          class="h-2 w-full border"
        />
      </div>
    </div>
  </div>
</template>
