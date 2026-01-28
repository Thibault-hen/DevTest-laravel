<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Checkbox } from '@/components/ui/checkbox';
import Label from '@/components/ui/label/Label.vue';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { QuestionPlayData } from '@/types/generated';
import { ArrowRight, Check } from 'lucide-vue-next';

defineProps<{
  question: QuestionPlayData;
  isLastQuestion: boolean;
  selectedAnswers: string | string[];
}>();

defineEmits<{
  'update:selectedAnswers': [value: string | string[]];
  next: [];
  submit: [];
}>();

const hasSelection = (answers: string | string[]) => {
  return Array.isArray(answers) ? answers.length > 0 : !!answers;
};
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
            $emit(
              'update:selectedAnswers',
              isSelected ? current.filter((id) => id !== answer.id) : [...current, answer.id],
            );
          }
        "
      />
      <span class="flex-1 text-sm md:text-base">{{ answer.content }}</span>
    </Label>
  </div>

  <div class="flex justify-end mt-4">
    <Button
      v-if="!isLastQuestion"
      variant="primary"
      @click="$emit('next')"
      class="gap-2"
      :disabled="!hasSelection(selectedAnswers)"
    >
      Suivant
      <ArrowRight :size="16" />
    </Button>
    <Button
      v-else
      variant="primary"
      @click="$emit('submit')"
      class="gap-2"
      :disabled="!hasSelection(selectedAnswers)"
    >
      <Check :size="16" />
      Terminer
    </Button>
  </div>
</template>
