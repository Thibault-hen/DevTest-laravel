<script setup lang="ts">
import HeadingSmall from '@/components/shared/HeadingSmall.vue';
import Card from '@/components/ui/card/Card.vue';
import { ResultQuestionData } from '@/types/generated';
import { Check, X } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
  summary: ResultQuestionData[];
}>();

const stats = computed(() => {
  const correct = props.summary.filter((r) => r.is_correct).length;
  const total = props.summary.length;
  return {
    correct,
    incorrect: total - correct,
    percentage: Math.round((correct / total) * 100),
  };
});
</script>

<template>
  <Card class="h-fit lg:sticky lg:top-20 max-h-[40vh] lg:max-h-[80vh] overflow-y-auto rounded-sm p-0">
    <HeadingSmall
      title="Résumé rapide"
      class="px-4 pt-4"
    />

    <ul class="flex gap-3 flex-col">
      <li
        v-for="(result, index) in summary"
        :key="result.question.id"
        class="flex gap-2.5 items-center group"
      >
        <span class="p-1 text-xs md:text-sm font-semibold w-8 h-8 flex items-center justify-center shrink-0">
          {{ index + 1 }}
        </span>

        <div
          class="w-6 h-6 shrink-0 flex items-center justify-center rounded-full transition-transform group-hover:scale-110"
          :class="result.is_correct ? 'bg-green-600' : 'bg-red-500'"
        >
          <component
            :is="result.is_correct ? Check : X"
            class="text-white w-4 h-4"
          />
        </div>
        <span class="truncate text-xs md:text-sm text-muted-foreground group-hover:text-foreground transition-colors">
          {{ result.question.content }}
        </span>
      </li>
    </ul>
  </Card>
</template>
