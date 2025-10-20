import { save } from '@/routes/result';
import type { QuizPlayData } from '@/types/generated';
import { QuestionAnswerData, ResultPostData } from '@/types/generated';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';

export function useQuizPlay(quiz: QuizPlayData) {
  // State
  const currentQuestionIndex = ref(0);
  const selectedAnswers = ref<Record<string, string | string[]>>({});
  const questionTimes = ref<Record<string, number>>({});
  const timerRef = ref<any>(null);
  const quizSubmitted = ref(false);

  // Computed properties
  const currentQuestion = computed(() => quiz.questions?.[currentQuestionIndex.value]);
  const totalQuestions = computed(() => quiz.questions?.length || 0);
  const progress = computed(() => ((currentQuestionIndex.value + 1) / totalQuestions.value) * 100);
  const isLastQuestion = computed(() => currentQuestionIndex.value === totalQuestions.value - 1);
  const currentTimer = computed(() => quiz.questions?.[currentQuestionIndex.value]?.timer || 0);

  // Current question's selected answers
  const currentSelectedAnswers = computed({
    get: () => selectedAnswers.value[currentQuestion.value?.id ?? ''] ?? (currentQuestion.value?.is_multiple ? [] : ''),
    set: (value) => {
      if (currentQuestion.value) {
        selectedAnswers.value[currentQuestion.value.id] = value;
      }
    },
  });

  // Methods
  const saveQuestionTime = (questionId: string, elapsedTime: number) => {
    questionTimes.value[questionId] = elapsedTime;
  };

  const clearCurrentAnswer = () => {
    if (currentQuestion.value) {
      selectedAnswers.value[currentQuestion.value.id] = currentQuestion.value.is_multiple ? [] : '';
    }
  };

  const handleTimeout = (elapsedTime: number) => {
    if (!currentQuestion.value) return;

    const currentQuestionId = currentQuestion.value.id;

    // Save elapsed time from timer
    saveQuestionTime(currentQuestionId, elapsedTime);

    // Clear answer (timed out)
    clearCurrentAnswer();

    // Move to next question or submit
    if (!isLastQuestion.value) {
      currentQuestionIndex.value++;
    } else {
      submitQuiz();
    }
  };

  const goToNext = () => {
    if (currentQuestionIndex.value < totalQuestions.value - 1 && currentQuestion.value) {
      const currentQuestionId = currentQuestion.value.id;
      const elapsedTime = timerRef.value?.getElapsedTime() || 0;

      saveQuestionTime(currentQuestionId, elapsedTime);
      currentQuestionIndex.value++;
    }
  };

  const submitQuiz = () => {
    if (quizSubmitted.value) return;

    // Save current question time if not already saved
    if (currentQuestion.value) {
      const currentQuestionId = currentQuestion.value.id;

      if (!questionTimes.value[currentQuestionId]) {
        const elapsedTime = timerRef.value?.getElapsedTime() || 0;
        saveQuestionTime(currentQuestionId, elapsedTime);
      }
    }

    const totalTime = Object.values(questionTimes.value).reduce((acc, time) => acc + time, 0);

    const questionResults = Object.entries(selectedAnswers.value).map(([questionId, answers]): QuestionAnswerData => {
      return {
        question_id: questionId,
        answers,
      };
    });

    const resultsData = {
      questions: questionResults,
      total_time: totalTime,
    } as ResultPostData;

    console.log('Submitting quiz results:', resultsData);
    router.post(save(quiz.slug), resultsData, {
      onError: (error) => {
        toast.error('Erreur', {
          description: "Une erreur est survenue lors de l'enregistrement de vos réponses.",
        });
        console.error(error);
      },
    });

    quizSubmitted.value = true;
  };

  return {
    // State
    currentQuestionIndex,
    selectedAnswers,
    questionTimes,
    timerRef,
    quizSubmitted,

    // Computed
    currentQuestion,
    totalQuestions,
    progress,
    isLastQuestion,
    currentTimer,
    currentSelectedAnswers,

    // Methods
    handleTimeout,
    goToNext,
    submitQuiz,
  };
}
