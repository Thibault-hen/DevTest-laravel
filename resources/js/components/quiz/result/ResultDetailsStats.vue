<script setup lang="ts">
import { DonutChart } from '@/components/ui/chart-donut';
import { quizConfig } from '@/constants/quizConfig';
import { ResultPercentageDataChart } from '@/types';
import { ResultData } from '@/types/generated';
import { ChartNoAxesColumnIncreasing, Check, Timer, X } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
  resultDetail: ResultData;
}>();

const answeredPercentage = computed((): number => {
  return Math.round((props.resultDetail.correct_answers_count / 20) * 100);
});

const chartData = computed((): ResultPercentageDataChart[] => {
  const correct = props.resultDetail.correct_answers_count;
  const incorrect = 20 - correct;
  return [
    {
      name: 'Bonnes réponses',
      value: correct,
    },
    {
      name: 'Mauvaises réponses',
      value: incorrect,
    },
  ];
});

const convertToMinutes = (ms: number): string => {
  const mins = Math.floor(ms / 1000 / 60);
  const secs = Math.floor((ms / 1000) % 60);
  return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
};
</script>

<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
    <div class="flex items-center gap-3 md:gap-4 p-3 md:p-4 rounded-xl border bg-background">
      <div class="relative w-12 h-12 md:w-14 md:h-14 flex-shrink-0">
        <DonutChart
          class="w-12 h-12 md:w-14 md:h-14"
          :donut-arc-width="8"
          index="name"
          :category="'value'"
          :data="chartData"
          :colors="['#009966', 'red']"
          :show-legend="false"
          :show-tooltip="false"
        />
      </div>
      <div class="min-w-0 flex-1">
        <p class="text-xs lg:text-sm font-medium text-muted-foreground uppercase tracking-wide mb-1">Score</p>
        <p class="text-lg lg:text-xl font-bold">
          {{ resultDetail.correct_answers_count
          }}<span class="text-muted-foreground">/{{ quizConfig.MIN_QUESTIONS }}</span>
        <p class="text-xs text-muted-foreground mt-1">
          {{ resultDetail.score }} pts
          </p>
        </p>
        <div class="flex flex-wrap gap-2 md:gap-3 mt-2 text-xs">
          <span class="flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-primary flex-shrink-0"></span>
            <span class="text-muted-foreground font-bold">{{ resultDetail.correct_answers_count }}</span>
            <Check
              class="text-primary flex-shrink-0"
              :size="16"
            />
          </span>
          <span class="flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-red-600 flex-shrink-0"></span>
            <span class="text-muted-foreground font-bold">{{ 20 - resultDetail.correct_answers_count }}</span>
            <X
              class="text-red-600 flex-shrink-0"
              :size="16"
            />
          </span>
        </div>
      </div>
    </div>

    <div class="flex items-center gap-3 md:gap-4 p-3 md:p-4 rounded-xl border bg-background">
      <Timer
        class="h-10 w-10 md:h-12 md:w-12 text-primary bg-primary/20 rounded-full p-2.5 md:p-3 border border-primary flex-shrink-0"
        :stroke-width="1.5"
      />
      <div class="min-w-0 flex-1">
        <p class="text-xs lg:text-sm font-medium text-muted-foreground uppercase tracking-wide mb-1">Temps écoulé</p>
        <p class="text-lg lg:text-xl font-bold">
          {{ convertToMinutes(resultDetail.completed_in) }}
        </p>
        <p class="text-xs text-muted-foreground mt-1">
          {{ Math.round(resultDetail.completed_in / 1000 / quizConfig.MIN_QUESTIONS) }}s par question
        </p>
      </div>
    </div>

    <div
      class="flex items-center gap-3 md:gap-4 p-3 md:p-4 rounded-xl border bg-background sm:col-span-2 lg:col-span-1"
    >
      <ChartNoAxesColumnIncreasing
        class="h-10 w-10 lg:h-12 lg:w-12 text-primary bg-primary/20 rounded-full p-2.5 lg:p-3 border border-primary flex-shrink-0"
        :stroke-width="1.5"
      />
      <div class="min-w-0 flex-1">
        <p class="text-xs lg:text-sm font-medium text-muted-foreground uppercase tracking-wide mb-1">Précision</p>
        <p class="text-lg lg:text-xl font-bold">{{ answeredPercentage }}%</p>
        <p class="text-xs text-muted-foreground mt-1">de réponses correctes</p>
      </div>
    </div>
  </div>
</template>
