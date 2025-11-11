import { save } from '@/routes/result';
import type { QuizPlayData } from '@/types/generated';
import { QuestionAnswerData, ResultPostData } from '@/types/generated';
import { errorToast } from '@/utils/toast';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

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
  const currentTimer = computed({
    get: () => quiz.questions?.[currentQuestionIndex.value]?.timer || 0,
    set: (value: number) => {
      if (quiz.questions && quiz.questions[currentQuestionIndex.value]) {
        quiz.questions[currentQuestionIndex.value].timer = value;
      }
    },
  });

  // Current question's selected answers
  const currentSelectedAnswers = computed({
    get: () => selectedAnswers.value[currentQuestion.value?.id ?? ''] ?? (currentQuestion.value?.is_multiple ? [] : ''),
    set: (value) => {
      if (currentQuestion.value) {
        selectedAnswers.value[currentQuestion.value.id] = value;
      }
    },
  });

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

    saveQuestionTime(currentQuestionId, elapsedTime);

    clearCurrentAnswer();

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

  const formatAnswer = (answer: string | string[] | null): string | string[] | null => {
    if (Array.isArray(answer) && answer.length === 0) {
      return null;
    }
    return answer === '' ? null : answer;
  };

  const submitQuiz = () => {
    if (quizSubmitted.value) return;

    if (currentQuestion.value) {
      const currentQuestionId = currentQuestion.value.id;

      if (!questionTimes.value[currentQuestionId]) {
        const elapsedTime = timerRef.value?.getElapsedTime() || 0;
        saveQuestionTime(currentQuestionId, elapsedTime);
      }
    }

    currentTimer.value = 0;

    const totalTime = Object.values(questionTimes.value).reduce((acc, time) => acc + time, 0);

    const questionResults = Object.entries(selectedAnswers.value).map(([questionId, answers]): QuestionAnswerData => {
      return {
        question_id: questionId,
        answers: formatAnswer(answers),
      };
    });

    const resultsData = {
      questions: questionResults,
      total_time: totalTime,
    } as ResultPostData;

    router.post(save(quiz.slug), resultsData, {
      replace: true,
      onError: (error) => {
        errorToast('Erreur', "Une erreur est survenue lors de l'enregistrement de vos réponses.");
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
