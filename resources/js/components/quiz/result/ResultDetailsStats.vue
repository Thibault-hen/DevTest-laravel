<script setup lang="ts">
import { DonutChart } from '@/components/ui/chart-donut';
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
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
    <div class="flex items-center gap-4 p-4 rounded-xl border bg-background">
      <div class="relative w-12 h-12 md:h-14 md:w-14 flex-shrink-0">
        <DonutChart
          class="w-12 h-12 md:h-14 md:w-14"
          :donut-arc-width="8"
          index="name"
          :category="'value'"
          :data="chartData"
          :colors="['#009966', 'red']"
          :show-legend="false"
          :show-tooltip="false"
        />
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
          <span class="text-xs md:text-sm font-bold text-muted-foreground"> {{ answeredPercentage }}% </span>
        </div>
      </div>
      <div>
        <p class="text-xs md:text-sm font-medium text-muted-foreground uppercase tracking-wide mb-1">Score</p>
        <p class="text-base md:text-lg font-bold">{{ resultDetail.correct_answers_count }}<span>/20</span></p>
        <div class="flex gap-3 mt-2 text-xs">
          <span class="flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-primary"></span>
            <span class="text-muted-foreground font-bold">{{ resultDetail.correct_answers_count }} </span>
            <Check
              class="text-primary"
              :size="18"
            />
          </span>
          <span class="flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-red-600"></span>
            <span class="text-muted-foreground font-bold">{{ 20 - resultDetail.correct_answers_count }} </span>
            <X
              class="text-red-600"
              :size="18"
            />
          </span>
        </div>
      </div>
    </div>

    <div class="flex items-center gap-4 p-4 rounded-xl border bg-background">
      <Timer
        class="h-10 w-10 md:h-12 md:w-12 text-primary bg-primary/20 rounded-full p-2 md:p-3 border border-primary"
        :stroke-width="1.5"
      />
      <div>
        <p class="text-xs md:text-sm font-medium text-muted-foreground uppercase tracking-wide mb-1">Temps écoulé</p>
        <p class="text-base md:text-lg font-bold">
          {{ convertToMinutes(resultDetail.completed_in) }}
        </p>
        <p class="text-xs text-muted-foreground mt-1">
          {{ Math.round(resultDetail.completed_in / 1000 / 20) }}s par question
        </p>
      </div>
    </div>

    <div class="flex items-center gap-4 p-4 rounded-xl border bg-background">
      <ChartNoAxesColumnIncreasing
        class="h-10 w-10 md:h-12 md:w-12 text-primary bg-primary/20 rounded-full p-2 md:p-3 border border-primary"
        :stroke-width="1.5"
      />
      <div>
        <p class="text-xs md:text-sm font-medium text-muted-foreground uppercase tracking-wide mb-1">Précision</p>
        <p class="text-base md:text-lg font-bold">{{ answeredPercentage }}%</p>
        <p class="text-xs text-muted-foreground mt-1">de réponses correctes</p>
      </div>
    </div>
  </div>
</template>
