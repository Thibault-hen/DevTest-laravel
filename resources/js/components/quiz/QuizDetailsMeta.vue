<script setup lang="ts">
import { QuizData } from '@/types/generated';
import { Calendar, ChartColumn, Clock, User } from 'lucide-vue-next';
import StarRating from './rating/StarRating.vue';

const props = defineProps<{ quiz: QuizData }>();
</script>

<template>
  <div class="grid grid-cols-2 gap-6 pt-4 md:grid-cols-3">
    <div class="flex items-center gap-2 text-sm">
      <Clock class="h-4 w-4 text-muted-foreground" />
      <div>
        <p class="text-xs text-muted-foreground">Durée</p>
        <p class="font-semibold">~ {{ props.quiz.duration }} min</p>
      </div>
    </div>

    <div class="flex items-center gap-2 text-sm">
      <User class="h-4 w-4 text-muted-foreground" />
      <div>
        <p class="text-xs text-muted-foreground">Auteur</p>
        <p class="font-semibold truncate">{{ props.quiz.author?.name || 'Anonyme' }}</p>
      </div>
    </div>

    <div class="flex items-center gap-2 text-sm">
      <Calendar class="h-4 w-4 text-muted-foreground" />
      <div>
        <p class="text-xs text-muted-foreground">Publié</p>
        <p class="font-semibold">{{ props.quiz.created_at }}</p>
      </div>
    </div>

    <div class="flex items-center gap-2 text-sm md:hidden">
      <ChartColumn class="h-4 w-4 text-muted-foreground" />
      <div>
        <p class="text-xs text-muted-foreground">Note</p>
        <StarRating
          :rating="props.quiz.average_rating ?? 0"
          :count="props.quiz.ratings_count ?? 0"
          :show-count="true"
          :show-precision="true"
        />
      </div>
    </div>
  </div>
</template>
