<script setup lang="ts">
import GlobalLoader from '@/components/loader/GlobalLoader.vue';
import AnswerChoices from '@/components/quiz/play/answer/AnswerChoices.vue';
import QuestionTimer from '@/components/quiz/play/QuestionTimer.vue';
import QuizPlayHeader from '@/components/quiz/play/QuizPlayHeader.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useQuizPlay } from '@/composables/useQuizPlay';
import type { QuizPlayData } from '@/types/generated';
import { Check } from 'lucide-vue-next';

const props = defineProps<{ quiz: QuizPlayData }>();

const {
  currentQuestion,
  currentQuestionIndex,
  totalQuestions,
  currentSelectedAnswers,
  currentTimer,
  isLastQuestion,
  progress,
  goToNext,
  handleTimeout,
  submitQuiz,
  timerRef,
} = useQuizPlay(props.quiz);
</script>

<template>
  <GlobalLoader />
  <div class="mx-auto max-w-4xl space-y-6">
    <QuizPlayHeader
      :quiz="props.quiz"
      :total-questions="totalQuestions"
      :progress="progress"
      :current-question-index="currentQuestionIndex"
    />

    <Card class="relative">
      <Transition
        name="fade"
        mode="out-in"
        appear
        :key="currentQuestionIndex"
      >
        <div class="flex flex-col gap-4">
          <CardHeader class="border-b">
            <CardTitle class="flex flex-col gap-4">
              <div class="flex justify-between items-start gap-4">
                <div class="flex flex-col gap-6">
                  <Badge
                    class="mb-2 text-sm px-4 w-fit"
                    variant="outline"
                  >
                    Question {{ currentQuestionIndex + 1 }}
                  </Badge>
                  <h2 class="text-sm md:text-lg lg:text-xl font-bold leading-tight">
                    {{ currentQuestion?.content }}
                  </h2>
                </div>

                <div class="absolute top-1 right-1 md:top-3 md:right-3">
                  <QuestionTimer
                    ref="timerRef"
                    :key="`timer-${currentQuestionIndex}`"
                    :duration="currentTimer"
                    @timeout="handleTimeout"
                    @finished="handleTimeout"
                    :is-last-question="isLastQuestion"
                  />
                </div>
              </div>

              <div
                v-if="currentQuestion?.is_multiple"
                class="text-sm text-muted-foreground flex items-center gap-2"
              >
                <Check :size="16" />
                Plusieurs réponses possibles
              </div>
            </CardTitle>
          </CardHeader>

          <CardContent>
            <AnswerChoices
              v-if="currentQuestion"
              :question="currentQuestion"
              :question-number="currentQuestionIndex + 1"
              :total-questions="totalQuestions"
              :is-last-question="isLastQuestion"
              v-model:selected-answers="currentSelectedAnswers"
              @next="goToNext"
              @submit="submitQuiz"
            />
          </CardContent>
        </div>
      </Transition>
    </Card>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.5s ease;
}

.fade-enter-to,
.fade-leave-from {
  opacity: 1;
}

.fade-enter-from {
  opacity: 0;
}
</style>
