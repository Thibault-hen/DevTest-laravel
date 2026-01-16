import { quizConfig } from '@/constants/quizConfig';
import { create, deleteMethod, publish, update } from '@/routes/admin/quizzes';
import { CreateOrUpdateQuizFormData } from '@/types';
import { AnswerData, PublishQuizData, QuestionData, QuizData, ThemeData } from '@/types/generated';
import { errorToast, successToast } from '@/utils/toast';
import { router, useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

export function useQuizAdminForm(
  closeDialog?: () => void,
  themes: ThemeData[] = [],
  quiz?: () => QuizData | null | undefined,
) {
  const createForm = useForm<CreateOrUpdateQuizFormData>({
    title: '442323232',
    description: '32323232222222222323',
    duration: quizConfig.QUIZ_MIN_TOTAL_DURATION_M,
    difficulty_id: '',
    is_published: false,
    category_id: '',
    themes_ids: [],
    icon: null,
    questions: Array.from({ length: quizConfig.MIN_QUESTIONS }, () => ({
      content: '333232323232',
      is_multiple: false,
      timer: quizConfig.MIN_QUESTION_TIMER_S,
      answers: Array.from({ length: quizConfig.MIN_ANSWERS_PER_QUESTION }, () => ({
        content: '2213323',
        is_correct: false,
      })),
    })),
  });

  const editForm = useForm<CreateOrUpdateQuizFormData>({
    title: '',
    description: '',
    duration: quizConfig.QUIZ_MIN_TOTAL_DURATION_M,
    difficulty_id: '',
    is_published: false,
    category_id: '',
    themes_ids: [],
    icon: null,
    questions: Array.from({ length: quizConfig.MIN_QUESTIONS }, () => ({
      content: '',
      is_multiple: false,
      timer: quizConfig.MIN_QUESTION_TIMER_S,
      answers: Array.from({ length: quizConfig.MIN_ANSWERS_PER_QUESTION }, () => ({
        content: '',
        is_correct: false,
      })),
    })),
  });

  // Populate editForm when quiz data is available
  watch(
    quiz || (() => null),
    (newQuiz) => {
      if (newQuiz) {
        editForm.title = newQuiz.title || '';
        editForm.description = newQuiz.description || '';
        editForm.duration = newQuiz.duration || quizConfig.QUIZ_MIN_TOTAL_DURATION_M;
        editForm.difficulty_id = newQuiz.difficulty?.id || '';
        editForm.is_published = newQuiz.is_published || false;
        editForm.category_id = newQuiz.category?.id || '';
        editForm.themes_ids = newQuiz.themes?.map((theme) => theme.id) || [];
        editForm.icon = null;
        editForm.questions =
          newQuiz.questions?.map((question: QuestionData) => ({
            content: question.content,
            is_multiple: question.is_multiple,
            timer: question.timer,
            answers: question.answers.map((answer: AnswerData) => ({
              content: answer.content,
              is_correct: answer.is_correct,
            })),
          })) ||
          Array.from({ length: quizConfig.MIN_QUESTIONS }, () => ({
            content: '',
            is_multiple: false,
            timer: quizConfig.MIN_QUESTION_TIMER_S,
            answers: Array.from({ length: quizConfig.MIN_ANSWERS_PER_QUESTION }, () => ({
              content: '',
              is_correct: false,
            })),
          }));
      }
    },
    { immediate: true },
  );

  const getTotalQuizDurationMin = (questions: QuestionData[]): number => {
    return Math.floor(questions.reduce((total, question) => total + question.timer, 0) / 60);
  };

  const isQuizInfoFilled = computed(() => {
    return (
      createForm.title.trim() !== '' &&
      createForm.description.trim() !== '' &&
      createForm.difficulty_id.trim() !== '' &&
      createForm.category_id.trim() !== '' &&
      createForm.duration > 0
    );
  });

  const createQuiz = (): void => {
    const totalDurationMin = getTotalQuizDurationMin(createForm.questions as QuestionData[]);

    createForm.transform((data) => ({
      ...data,
      duration: totalDurationMin,
    }));
    console.log('Creating quiz with data:', totalDurationMin);
    createForm.post(create().url, {
      onSuccess: () => {
        successToast('Succès', 'Quiz créé avec succès.');
        if (closeDialog) closeDialog();
        createForm.reset();
      },
      onError: () => {
        errorToast('Erreur', 'Une erreur est survenue lors de la création du quiz.');
      },
    });
  };

  const updateQuiz = (quizId: string): void => {
    const totalDurationMin = getTotalQuizDurationMin(editForm.questions as QuestionData[]);

    editForm.transform((data) => ({
      ...data,
      duration: totalDurationMin,
    }));
    editForm.put(update(quizId).url, {
      onSuccess: () => {
        successToast('Succès', 'Quiz mis à jour avec succès.');
        if (closeDialog) closeDialog();
        editForm.reset();
      },
      onError: () => {
        errorToast('Erreur', 'Une erreur est survenue lors de la mise à jour du quiz.');
      },
    });
  };

  const deleteQuiz = (quizId: string): void => {
    editForm.delete(deleteMethod(quizId).url, {
      onSuccess: () => {
        successToast('Succès', 'Quiz supprimé avec succès.');
        if (closeDialog) closeDialog();
      },
      onError: () => {
        errorToast('Erreur', 'Une erreur est survenue lors de la suppression du quiz.');
      },
    });
  };

  const setPublished = (
    quizId: string,
    data: PublishQuizData,
    callbacks?: {
      onStart?: () => void;
      onError?: () => void;
      onFinish?: () => void;
    },
  ): void => {
    router.put(publish(quizId).url, data, {
      onStart: () => {
        callbacks?.onStart?.();
      },
      onFinish: () => {
        callbacks?.onFinish?.();
      },
      onSuccess: () => {
        successToast('Succès', 'Le statut de publication du quiz a été mis à jour.');
      },
      onError: () => {
        errorToast('Erreur', 'Une erreur est survenue lors de la publication du quiz.');
      },
    });
  };

  const themeOptions = computed(() =>
    themes.map((theme) => ({
      id: theme.id,
      label: theme.title,
    })),
  );

  return {
    createForm,
    editForm,
    isQuizInfoFilled,
    createQuiz,
    themeOptions,
    updateQuiz,
    deleteQuiz,
    setPublished,
  };
}
