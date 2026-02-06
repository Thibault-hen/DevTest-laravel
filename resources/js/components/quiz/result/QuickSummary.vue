<script setup lang="ts">
import HeadingSmall from '@/components/shared/HeadingSmall.vue';
import Card from '@/components/ui/card/Card.vue';
import { ResultQuestionData } from '@/types/generated';
import { Check, X } from 'lucide-vue-next';

const props = defineProps<{
  summary: ResultQuestionData[];
}>();

const correctCount = props.summary.filter((r) => r.is_correct).length;
const totalCount = props.summary.length;
const percentage = Math.round((correctCount / totalCount) * 100);
</script>

<template>
  <Card class="overflow-auto scrollbar-hidden gap-4 h-fit xl:sticky xl:top-20 max-h-[40vh] lg:max-h-[80vh] p-4 md:p-6">
    <div class="space-y-4">
      <div>
        <HeadingSmall title="Résumé rapide" />
        <p class="text-sm text-muted-foreground mt-1">
          {{ correctCount }}/{{ totalCount }} correctes ({{ percentage }}%)
        </p>
      </div>

      <ul class="flex gap-2 flex-col">
        <li
          v-for="(result, index) in props.summary"
          :key="result.question.id"
          class="border border-transparent hover:border-primary flex gap-3 items-center p-2 rounded-lg hover:dark:bg-accent transition-colors cursor-pointer group"
        >
          <span
            class="border text-xs font-medium w-6 h-6 flex items-center justify-center shrink-0 rounded-full bg-muted"
          >
            {{ index + 1 }}
          </span>

          <div
            class="w-5 h-5 shrink-0 flex items-center justify-center rounded-full"
            :class="result.is_correct ? 'bg-green-600' : 'bg-red-600'"
          >
            <component
              :is="result.is_correct ? Check : X"
              class="w-3 h-3"
              :stroke-width="4"
            />
          </div>

          <span class="truncate text-sm transition-colors flex-1 group-hover:dark:text-white">
            {{ result.question.content }}
          </span>
        </li>
      </ul>
    </div>
  </Card>
</template>

<style scoped>
.scrollbar-hidden::-webkit-scrollbar {
  display: none;
}

.scrollbar-hidden {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
