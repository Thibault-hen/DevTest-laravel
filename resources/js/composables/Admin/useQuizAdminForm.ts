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
  const form = useForm<CreateOrUpdateQuizFormData>({
    title: '',
    description: '',
    duration: 10,
    difficulty_id: '',
    is_published: false,
    category_id: '',
    themes_ids: [],
    icon: null,
    questions: Array.from({ length: quizConfig.MIN_QUESTIONS }, () => ({
      content: '',
      is_multiple: false,
      answers: Array.from({ length: quizConfig.MIN_ANSWERS_PER_QUESTION }, () => ({
        content: '',
        is_correct: false,
      })),
    })),
  });

  const editForm = useForm<CreateOrUpdateQuizFormData>({
    title: '',
    description: '',
    duration: 10,
    difficulty_id: '',
    is_published: false,
    category_id: '',
    themes_ids: [],
    icon: null,
    questions: Array.from({ length: quizConfig.MIN_QUESTIONS }, () => ({
      content: '',
      is_multiple: false,
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
        editForm.duration = newQuiz.duration || 10;
        editForm.difficulty_id = newQuiz.difficulty?.id || '';
        editForm.is_published = newQuiz.is_published || false;
        editForm.category_id = newQuiz.category?.id || '';
        editForm.themes_ids = newQuiz.themes?.map((theme) => theme.id) || [];
        editForm.icon = null;
        editForm.questions =
          newQuiz.questions?.map((question: QuestionData) => ({
            content: question.content,
            is_multiple: question.is_multiple,
            answers: question.answers.map((answer: AnswerData) => ({
              content: answer.content,
              is_correct: answer.is_correct,
            })),
          })) ||
          Array.from({ length: quizConfig.MIN_QUESTIONS }, () => ({
            content: '',
            is_multiple: false,
            answers: Array.from({ length: quizConfig.MIN_ANSWERS_PER_QUESTION }, () => ({
              content: '',
              is_correct: false,
            })),
          }));
      }
    },
    { immediate: true },
  );

  const isQuizInfoFilled = computed(() => {
    return (
      form.title.trim() !== '' &&
      form.description.trim() !== '' &&
      form.difficulty_id.trim() !== '' &&
      form.category_id.trim() !== '' &&
      form.duration > 0
    );
  });

  const createQuiz = (): void => {
    form.post(create().url, {
      onSuccess: () => {
        successToast('Succès', 'Quiz créé avec succès.');
        if (closeDialog) closeDialog();
        form.reset();
      },
      onError: () => {
        console.log('Error creating quiz', form.errors);
        errorToast('Erreur', 'Une erreur est survenue lors de la création du quiz.');
      },
      preserveScroll: true,
    });
  };

  const updateQuiz = (quizId: string): void => {
    editForm.put(update(quizId).url, {
      onSuccess: () => {
        successToast('Succès', 'Quiz mis à jour avec succès.');
        if (closeDialog) closeDialog();
        form.reset();
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
        form.reset();
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
    form,
    editForm,
    isQuizInfoFilled,
    createQuiz,
    themeOptions,
    updateQuiz,
    deleteQuiz,
    setPublished,
  };
}
