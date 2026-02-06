<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { QuestionPlayData } from '@/types/generated';
import { ArrowRight, Check, Circle, Square } from 'lucide-vue-next';

defineProps<{
  question: QuestionPlayData;
  isLastQuestion: boolean;
  selectedAnswers: string | string[];
}>();

const emit = defineEmits<{
  'update:selectedAnswers': [value: string | string[]];
  next: [];
  submit: [];
}>();

const hasSelection = (answers: string | string[]) => {
  return Array.isArray(answers) ? answers.length > 0 : !!answers;
};

const isSelected = (answerId: string, currentSelection: string | string[]) => {
  if (Array.isArray(currentSelection)) {
    return currentSelection.includes(answerId);
  }
  return currentSelection === answerId;
};

const toggleSelection = (answerId: string, isMultiple: boolean, currentSelection: string | string[]) => {
  if (!isMultiple) {
    emit('update:selectedAnswers', answerId);
    return;
  }

  const list = Array.isArray(currentSelection) ? [...currentSelection] : [];
  if (list.includes(answerId)) {
    emit(
      'update:selectedAnswers',
      list.filter((id) => id !== answerId),
    );
  } else {
    emit('update:selectedAnswers', [...list, answerId]);
  }
};
</script>

<template>
  <div class="space-y-6">
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
      <button
        v-for="answer in question.shuffled_answers"
        :key="answer.id"
        @click="toggleSelection(answer.id, question.is_multiple, selectedAnswers)"
        class="cursor-pointer group shadow-xs relative dark:bg-background flex items-center gap-4 rounded-xl border-1 !border-border p-4 text-left transition-all duration-200 outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 hover:!bg-accent/15"
        :class="[
          isSelected(answer.id, selectedAnswers)
            ? 'border-primary bg-primary/5 shadow-[0_0_0_1px_rgba(var(--primary)_/_1)]'
            : 'border-muted hover:border-primary/50 bg-card',
        ]"
      >
        <div
          class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border transition-colors duration-200"
          :class="[
            isSelected(answer.id, selectedAnswers)
              ? 'border-primary bg-primary text-primary-foreground'
              : 'border-muted-foreground/30 group-hover:border-primary',
          ]"
        >
          <template v-if="question.is_multiple">
            <Check
              v-if="isSelected(answer.id, selectedAnswers)"
              class="h-4 w-4"
            />
            <Square
              v-else
              class="h-4 w-4 text-transparent"
            />
          </template>
          <template v-else>
            <Check
              v-if="isSelected(answer.id, selectedAnswers)"
              class="h-4 w-4"
            />
            <Circle
              v-else
              class="h-4 w-4 text-transparent"
            />
          </template>
        </div>

        <span class="font-medium leading-snug text-sm md:text-base">
          {{ answer.content }}
        </span>
      </button>
    </div>

    <div class="flex justify-end pt-4">
      <Button
        v-if="!isLastQuestion"
        @click="$emit('next')"
        class="group min-w-[140px] gap-2"
        :disabled="!hasSelection(selectedAnswers)"
      >
        Suivant
        <ArrowRight class="h-4 w-4 transition-transform group-hover:translate-x-1" />
      </Button>

      <Button
        v-else
        @click="$emit('submit')"
        class="group min-w-[140px] gap-2 animate-pulse"
        :disabled="!hasSelection(selectedAnswers)"
      >
        <Check class="h-4 w-4" />
        Terminer
      </Button>
    </div>
  </div>
</template>
