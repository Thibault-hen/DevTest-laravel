import { save } from '@/routes/result';
import type { QuizPlayData } from '@/types/generated';
import { QuestionAnswerData, ResultPostData } from '@/types/generated';
import { errorToast } from '@/utils/toast';
import { router } from '@inertiajs/vue3';
import { computed, onUnmounted, ref } from 'vue';

export function useQuizPlay(quiz: QuizPlayData) {
  // State
  const currentQuestionIndex = ref(0);
  const selectedAnswers = ref<Record<string, string | string[]>>({});
  const isSubmitting = ref(false);

  // Global timer - starts when composable is created
  const startTime = Date.now();
  const elapsedSeconds = ref(0);
  const timerInterval = setInterval(() => {
    elapsedSeconds.value = Math.floor((Date.now() - startTime) / 1000);
  }, 1000);

  const stopTimer = () => {
    clearInterval(timerInterval);
  };

  onUnmounted(stopTimer);

  // Computed
  const currentQuestion = computed(() => quiz.questions?.[currentQuestionIndex.value]);
  const totalQuestions = computed(() => quiz.questions?.length || 0);
  const progress = computed(() => ((currentQuestionIndex.value + 1) / totalQuestions.value) * 100);
  const isLastQuestion = computed(() => currentQuestionIndex.value === totalQuestions.value - 1);
  const questionTimer = computed(() => currentQuestion.value?.timer || 0);

  const currentSelectedAnswers = computed({
    get: () => selectedAnswers.value[currentQuestion.value?.id ?? ''] ?? (currentQuestion.value?.is_multiple ? [] : ''),
    set: (value) => {
      if (currentQuestion.value) {
        selectedAnswers.value[currentQuestion.value.id] = value;
      }
    },
  });

  const clearCurrentAnswer = () => {
    if (currentQuestion.value) {
      selectedAnswers.value[currentQuestion.value.id] = currentQuestion.value.is_multiple ? [] : '';
    }
  };

  const goToNext = () => {
    if (currentQuestionIndex.value < totalQuestions.value - 1) {
      currentQuestionIndex.value++;
    }
  };

  const handleTimeout = () => {
    clearCurrentAnswer();

    if (!isLastQuestion.value) {
      goToNext();
    } else {
      submitQuiz();
    }
  };

  const formatAnswer = (answer: string | string[] | null): string | string[] | null => {
    if (Array.isArray(answer) && answer.length === 0) {
      return null;
    }
    return answer === '' ? null : answer;
  };

  const submitQuiz = () => {
    if (isSubmitting.value) return;
    isSubmitting.value = true;

    stopTimer();
    const totalTime = Date.now() - startTime;

    const questionResults = Object.entries(selectedAnswers.value).map(
      ([questionId, answers]): QuestionAnswerData => ({
        question_id: questionId,
        answers: formatAnswer(answers),
      }),
    );

    const resultsData: ResultPostData = {
      questions: questionResults,
      total_time: totalTime,
    };

    router.post(save(quiz.slug), resultsData, {
      replace: true,
      onError: (error) => {
        errorToast("Une erreur est survenue lors de l'enregistrement de vos réponses.");
        console.error(error);
        isSubmitting.value = false;
      },
    });
  };

  return {
    // State
    currentQuestionIndex,
    elapsedSeconds,
    isSubmitting,

    // Computed
    currentQuestion,
    totalQuestions,
    progress,
    isLastQuestion,
    questionTimer,
    currentSelectedAnswers,

    // Methods
    handleTimeout,
    goToNext,
    submitQuiz,
  };
}
