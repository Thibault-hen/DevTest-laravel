<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Checkbox } from '@/components/ui/checkbox';
import Label from '@/components/ui/label/Label.vue';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { QuestionPlayData } from '@/types/generated';
import { ArrowRight, Check } from 'lucide-vue-next';

defineProps<{
  question: QuestionPlayData;
  questionNumber: number;
  totalQuestions: number;
  isLastQuestion: boolean;
  selectedAnswers: string | string[];
}>();

defineEmits<{
  (e: 'update:selectedAnswers', value: string | string[]): void;
  (e: 'next'): void;
  (e: 'submit'): void;
}>();
</script>

<template>
  <RadioGroup
    v-if="!question.is_multiple"
    :model-value="selectedAnswers"
    @update:model-value="$emit('update:selectedAnswers', $event)"
    class="space-y-3"
  >
    <Label
      v-for="answer in question.shuffled_answers"
      :key="answer.id"
      :for="answer.id"
      class="flex items-center space-x-3 rounded-lg border p-2 md:p-4 transition-colors dark:hover:bg-accent hover:bg-primary/30 hover:border-primary cursor-pointer w-full"
      :class="{
        'border-primary dark:bg-primary/5 bg-primary/40 text-muted-foreground': selectedAnswers === answer.id,
      }"
    >
      <RadioGroupItem
        :id="answer.id"
        :value="answer.id"
      />
      <span class="flex-1 text-sm md:text-base">{{ answer.content }}</span>
    </Label>
  </RadioGroup>

  <div
    v-else
    class="space-y-3"
  >
    <Label
      v-for="answer in question.shuffled_answers"
      :key="answer.id"
      :for="answer.id"
      class="flex items-center space-x-3 rounded-lg border p-2 md:p-4 transition-colors dark:hover:bg-accent hover:bg-primary/30 hover:border-primary cursor-pointer w-full"
      :class="{
        'border-primary dark:bg-primary/5 bg-primary/40 text-muted-foreground':
          Array.isArray(selectedAnswers) && selectedAnswers.includes(answer.id),
      }"
    >
      <Checkbox
        :id="answer.id"
        :model-value="Array.isArray(selectedAnswers) && selectedAnswers.includes(answer.id)"
        @update:model-value="
          () => {
            const current = Array.isArray(selectedAnswers) ? [...selectedAnswers] : [];
            const isSelected = current.includes(answer.id);
            if (isSelected) {
              $emit(
                'update:selectedAnswers',
                current.filter((id) => id !== answer.id),
              );
            } else {
              $emit('update:selectedAnswers', [...current, answer.id]);
            }
          }
        "
      />
      <span class="flex-1 text-sm md:text-base">{{ answer.content }}</span>
    </Label>
  </div>

  <div class="flex items-center justify-between gap-4 mt-4">
    <Button
      v-if="!isLastQuestion"
      variant="primary"
      @click="$emit('next')"
      class="gap-2 ml-auto"
      :disabled="
        question.is_multiple ? !Array.isArray(selectedAnswers) || selectedAnswers.length === 0 : !selectedAnswers
      "
    >
      Suivant
      <ArrowRight :size="16" />
    </Button>
    <Button
      v-else
      variant="primary"
      @click="$emit('submit')"
      class="gap-2 ml-auto"
      :disabled="!selectedAnswers || (Array.isArray(selectedAnswers) && selectedAnswers.length === 0)"
    >
      <Check :size="16" />
      Terminer
    </Button>
  </div>
</template>
