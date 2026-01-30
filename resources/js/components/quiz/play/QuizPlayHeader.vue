<script setup lang="ts">
import CategoryBadge from '@/components/shared/badges/CategoryBadge.vue';
import DifficultyBadge from '@/components/shared/badges/DifficultyBadge.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import Progress from '@/components/ui/progress/Progress.vue';
import { QuizPlayData } from '@/types/generated';
import { Clock } from 'lucide-vue-next';

const props = defineProps<{
  quiz: QuizPlayData;
  currentQuestionIndex: number;
  totalQuestions: number;
  progress: number;
}>();
</script>

<template>
  <Card>
    <CardHeader>
      <div class="flex items-start justify-between gap-4">
        <div class="space-y-4 flex-1">
          <div class="flex flex-wrap items-center gap-1.5">
            <DifficultyBadge
              v-if="props.quiz.difficulty"
              :difficulty="props.quiz.difficulty"
            />
            <CategoryBadge
              v-if="props.quiz.category"
              :category="props.quiz.category"
            />
            <Badge
              variant="outline"
              class="p-1.5"
            >
              <Clock />
              ~ {{ props.quiz.duration }} min
            </Badge>
          </div>
          <CardTitle class="text-base md:text-xl lg:text-2xl flex items-center gap-2">
            <img
              v-if="quiz.image_url"
              :src="`/${quiz.image_url}`"
              :alt="quiz.image_text || 'Quiz image'"
              class="flex h-6 rounded"
            />{{ props.quiz.title }}</CardTitle
          >
          <CardDescription>{{ props.quiz.description }}</CardDescription>
        </div>
        <div class="flex items-center gap-2 text-sm text-muted-foreground">
          <!--timer-->
        </div>
      </div>
    </CardHeader>

    <CardContent>
      <div class="space-y-2">
        <div class="flex items-center justify-between text-sm">
          <span class="font-medium">Progression</span>
          <span class="text-muted-foreground"> Question {{ currentQuestionIndex + 1 }} sur {{ totalQuestions }} </span>
        </div>
        <Progress
          :model-value="progress"
          class="h-2"
        />
      </div>
    </CardContent>
  </Card>
</template>
