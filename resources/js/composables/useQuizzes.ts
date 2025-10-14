import type { QuizzesData } from '@/types/generated';
import { computed, ref, watch } from 'vue';

export const useQuizzes = (props: QuizzesData) => {
  // pagination
  const ITEMS_PER_PAGE = 8;
  const itemsPerPage = ref<number>(ITEMS_PER_PAGE);
  const page = ref<number>(1);
  const totalPages = computed(() => {
    return Math.ceil(filteredQuizzes.value.quizzes.length / itemsPerPage.value);
  });
  const paginatedQuizzes = computed(() => {
    const start = (page.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return filteredQuizzes.value.quizzes.slice(start, end);
  });

  // filters
  const selectedDifficulties = ref<string[]>([]);
  const selectedThemes = ref<string[]>([]);
  const selectedCategories = ref<string[]>([]);
  const showFilters = ref(false);

  // search field
  const searchInput = ref<string>('');
  const searchText = ref<string>('');

  watch([selectedDifficulties, selectedThemes, selectedCategories, searchText], () => {
    page.value = 1;
  });

  const filteredQuizzes = computed((): QuizzesData => {
    let quizzes = props.quizzes;

    if (selectedDifficulties.value.length > 0) {
      quizzes = quizzes.filter((quiz) => selectedDifficulties.value.includes(quiz?.difficulty?.level ?? ''));
    }

    if (selectedThemes.value.length > 0) {
      quizzes = quizzes.filter((quiz) => quiz?.themes?.some((theme) => selectedThemes.value.includes(theme.title)));
    }

    if (selectedCategories.value.length > 0) {
      quizzes = quizzes.filter((quiz) => selectedCategories.value.includes(quiz.category?.name ?? ''));
    }

    if (searchText.value) {
      quizzes = quizzes.filter(
        (quiz) =>
          quiz.title.toLocaleLowerCase().includes(searchText.value?.toLocaleLowerCase() ?? '') ||
          quiz.category?.name.toLocaleLowerCase().includes(searchText.value.toLocaleLowerCase()) ||
          quiz.themes?.some((theme) => theme.title.toLocaleLowerCase().includes(searchText.value.toLocaleLowerCase())),
      );
    }

    return {
      ...props,
      quizzes,
    };
  });

  const applySearch = (): void => {
    searchText.value = searchInput.value;
  };

  const resetSearch = (): void => {
    searchInput.value = '';
    searchText.value = '';
  };

  const resultLabel = (): string => {
    const count = filteredQuizzes.value.quizzes.length;
    return `${count} résultat${count > 1 ? 's' : ''}`;
  };

  return {
    itemsPerPage,
    page,
    totalPages,
    paginatedQuizzes,
    selectedDifficulties,
    selectedCategories,
    selectedThemes,
    showFilters,
    searchInput,
    searchText,
    applySearch,
    resetSearch,
    resultLabel,
    filteredQuizzes,
  };
};
