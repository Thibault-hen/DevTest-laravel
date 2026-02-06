<script setup lang="ts">
import AnswerChoices from '@/components/quiz/play/answer/AnswerChoices.vue';
import QuestionTimer from '@/components/quiz/play/QuestionTimer.vue';
import QuizPlayHeader from '@/components/quiz/play/QuizPlayHeader.vue';
import { Card, CardContent } from '@/components/ui/card';
import Separator from '@/components/ui/separator/Separator.vue';
import { useQuizPlay } from '@/composables/useQuizPlay';
import type { QuizPlayData } from '@/types/generated';
import { Check } from 'lucide-vue-next';

const props = defineProps<{ quiz: QuizPlayData }>();

const {
  currentQuestion,
  currentQuestionIndex,
  totalQuestions,
  currentSelectedAnswers,
  questionTimer,
  isLastQuestion,
  progress,
  goToNext,
  handleTimeout,
  submitQuiz,
} = useQuizPlay(props.quiz);
</script>

<template>
  <div class="mx-auto w-full max-w-4xl space-y-8">
    <QuizPlayHeader
      :quiz="props.quiz"
      :total-questions="totalQuestions"
      :progress="progress"
      :current-question-index="currentQuestionIndex"
    />

    <div class="relative">
      <Transition
        name="slide-fade"
        mode="out-in"
      >
        <Card
          v-if="currentQuestion"
          :key="currentQuestion.id"
          class="overflow-visible border shadow-none backdrop-blur-sm md:bg-card md:shadow-sm md:border md:border-border"
        >
          <CardContent class="p-4 md:p-6 lg:p-10 space-y-10">
            <div class="relative flex flex-col gap-6">
              <div class="flex items-start justify-between gap-6">
                <div class="max-w-2xl">
                  <div
                    v-if="currentQuestion.is_multiple"
                    class="inline-flex items-center gap-1.5 rounded-full border border-primary/20 bg-primary/5 px-3 py-1 text-xs font-semibold text-primary uppercase tracking-wide"
                  >
                    <Check class="h-3 w-3" />
                    Plusieurs réponses possibles
                  </div>
                  <span class="text-sm">Question {{ currentQuestionIndex + 1 }} sur {{ totalQuestions }}</span>

                  <h2 class="text-lg font-bold leading-tight tracking-tight md:text-2xl text-pretty text-foreground">
                    {{ currentQuestion.content }}
                  </h2>
                </div>

                <div class="hidden shrink-0 md:block">
                  <QuestionTimer
                    :key="`timer-${currentQuestionIndex}`"
                    :duration="questionTimer"
                    @timeout="handleTimeout"
                  />
                </div>
              </div>

              <div class="self-end md:hidden">
                <QuestionTimer
                  :key="`timer-mobile-${currentQuestionIndex}`"
                  :duration="questionTimer"
                  @timeout="handleTimeout"
                />
              </div>
            </div>

            <Separator class="bg-primary" />

            <div class="pt-2">
              <AnswerChoices
                :question="currentQuestion"
                :is-last-question="isLastQuestion"
                v-model:selected-answers="currentSelectedAnswers"
                @next="goToNext"
                @submit="submitQuiz"
              />
            </div>
          </CardContent>
        </Card>
      </Transition>
    </div>
  </div>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.slide-fade-enter-from {
  opacity: 0;
  transform: translateX(20px);
}

.slide-fade-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}
</style>
