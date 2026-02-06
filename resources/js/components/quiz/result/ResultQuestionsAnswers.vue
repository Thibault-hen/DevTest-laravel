<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import { AnswerResultData, ResultQuestionData } from '@/types/generated';
import { Check, Circle, X } from 'lucide-vue-next';

const props = defineProps<{
  questions: ResultQuestionData[];
  userAnswers: AnswerResultData[];
}>();

const isUserAnswerIncorrect = (answerId: string): boolean => {
  return props.userAnswers.some((answer) => answer.id === answerId && !answer.is_correct);
};

const getAnswerStatus = (answer: any) => {
  if (answer.is_correct) return 'correct';
  if (isUserAnswerIncorrect(answer.id)) return 'incorrect';
  return 'neutral';
};
</script>

<template>
  <div class="flex flex-col gap-6">
    <Card
      class="overflow-hidden border transition-all duration-300"
      v-for="(questionResult, index) in questions"
      :key="questionResult.question.id"
    >
      <CardHeader class="pb-4">
        <CardTitle class="flex items-start justify-between gap-4">
          <div class="flex flex-col gap-3 flex-1">
            <div class="flex items-center gap-3">
              <div
                class="bg-background border flex items-center justify-center w-26 text-sm h-8 tracking-wide rounded-lg dark:text-white font-bold shadow-xs"
              >
                Question {{ index + 1 }}
              </div>
              <div
                class="px-3 py-1 rounded-full text-xs font-medium border shadow-sm"
                :class="
                  questionResult.is_correct
                    ? 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800'
                    : 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800'
                "
              >
                {{ questionResult.is_correct ? 'Bonne réponse' : 'Mauvaise réponse' }}
              </div>
            </div>
            <p class="text-foreground font-medium leading-relaxed">
              {{ questionResult.question.content }}
            </p>
          </div>
        </CardTitle>
      </CardHeader>

      <CardContent class="pt-0">
        <ul class="space-y-2">
          <li
            v-for="answer in questionResult.question.answers"
            :key="answer.id"
            class="group/answer flex items-center gap-3 p-3 rounded-lg border transition-all duration-200 hover:shadow-sm"
            :class="{
              'border-green-300 bg-green-100/50 dark:border-green-800 dark:bg-green-950/20': answer.is_correct,
              'border-red-300 bg-red-100/50 dark:border-red-800 dark:bg-red-950/20': isUserAnswerIncorrect(answer.id),
              'border-border bg-background hover:bg-muted/30': getAnswerStatus(answer) === 'neutral',
            }"
          >
            <component
              :is="answer.is_correct ? Check : isUserAnswerIncorrect(answer.id) ? X : Circle"
              :class="[
                'w-5 h-5 rounded-lg p-0.5 flex items-center justify-center transition-colors',
                {
                  'border-green-600 bg-green-600': answer.is_correct,
                  'border-red-600 bg-red-600': isUserAnswerIncorrect(answer.id),
                  'text-white': answer.is_correct || isUserAnswerIncorrect(answer.id),
                  'border-muted-foreground/30 text-muted-foreground/40': getAnswerStatus(answer) === 'neutral',
                },
              ]"
            />

            <span
              class="text-sm leading-relaxed transition-colors"
              :class="{
                'text-green-900 dark:text-green-100 font-medium': answer.is_correct,
                'text-red-900 dark:text-red-100 font-medium': isUserAnswerIncorrect(answer.id),
                'text-muted-foreground': getAnswerStatus(answer) === 'neutral',
              }"
            >
              {{ answer.content }}
            </span>
          </li>
        </ul>
      </CardContent>
    </Card>
  </div>
</template>
