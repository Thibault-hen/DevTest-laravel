<script setup lang="ts">
import CategoryFilter from '@/components/quiz/filters/CategoryFilter.vue';
import DifficultyFilter from '@/components/quiz/filters/DifficultyFilter.vue';
import ThemeFilter from '@/components/quiz/filters/ThemeFilter.vue';
import NoQuizFound from '@/components/quiz/NoQuizFound.vue';
import QuizCard from '@/components/quiz/QuizCard.vue';
import Breadcrumbs from '@/components/shared/Breadcrumbs.vue';
import Heading from '@/components/shared/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardTitle } from '@/components/ui/card';
import {
  Pagination,
  PaginationContent,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from '@/components/ui/pagination';
import { useQuizzes } from '@/composables/useQuizzes';
import AppLayout from '@/layouts/AppLayout.vue';
import { home, quizzes } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { QuizzesData } from '@/types/generated';
import { ChevronRight, ChevronUp, Search, X } from 'lucide-vue-next';
import { watch } from 'vue';
const props = defineProps<QuizzesData>();

const {
  showFilters,
  selectedCategories,
  selectedDifficulties,
  selectedThemes,
  searchInput,
  searchText,
  applySearch,
  resetSearch,
  paginatedQuizzes,
  itemsPerPage,
  totalPages,
  page,
  filteredQuizzes,
  resultLabel,
} = useQuizzes(props);

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Accueil',
    href: home().url,
  },
  {
    title: 'Quizz',
    href: quizzes().url,
  },
];

defineOptions({
  layout: AppLayout,
});

watch(page, () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>

<template>
  <section class="flex flex-col px-4 py-6">
    <Breadcrumbs :breadcrumbs="breadcrumbs" />
    <div class="mt-8">
      <Heading
        title="Quiz"
        description="Explorez nos quiz disponibles"
      />
      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <aside class="lg:col-span-1">
          <Card class="p-4">
            <CardTitle class="mb-4 font-semibold">Filtres</CardTitle>
            <CardContent class="flex flex-col gap-4 p-0">
              <Button
                @click="showFilters = !showFilters"
                class="flex md:hidden"
              >
                <span class="flex items-center gap-2">
                  {{ showFilters ? 'Masquer les filtres' : 'Afficher les filtres' }}
                  <ChevronRight v-if="!showFilters" />
                  <ChevronUp v-if="showFilters" />
                </span>
              </Button>
              <div
                class="flex-col gap-2"
                :class="showFilters ? 'flex' : 'hidden md:flex'"
              >
                <DifficultyFilter
                  :difficulties="props.difficulties"
                  v-model:difficulty="selectedDifficulties"
                />
                <div class="flex flex-col justify-between gap-2 md:flex-row lg:flex-col">
                  <ThemeFilter
                    :themes="props.themes"
                    v-model:theme="selectedThemes"
                    class="w-full"
                  />
                  <CategoryFilter
                    :categories="props.categories"
                    v-model:category="selectedCategories"
                    class="w-full"
                  />
                </div>
              </div>
            </CardContent>
          </Card>
        </aside>

        <div class="flex flex-col gap-6 lg:col-span-2">
          <Card class="p-4">
            <div class="flex items-center">
              <div class="relative flex w-full items-center lg:lg:w-1/2">
                <input
                  type="search"
                  v-model="searchInput"
                  @keyup.enter="applySearch"
                  placeholder="Rechercher un quiz..."
                  class="relative w-full rounded-l-md border px-4 py-1.5"
                />
                <Button
                  variant="ghost"
                  v-if="searchInput || searchText"
                  class="!dark:bg-none absolute right-0 text-pretty hover:bg-transparent hover:text-primary hover:dark:bg-transparent"
                  @click="resetSearch"
                  ><X
                /></Button>
              </div>
              <Button
                variant="default"
                class="!rounded-none !rounded-r-md"
                @click="applySearch"
                ><Search
              /></Button>
            </div>
          </Card>

          <span class="text-sm font-bold capitalize lg:text-base">{{ resultLabel() }}</span>

          <NoQuizFound v-if="filteredQuizzes.quizzes.length === 0" />
          <div
            v-else
            class="flex flex-col gap-4"
          >
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
              <QuizCard
                v-for="quiz in paginatedQuizzes"
                :key="quiz.id"
                :quiz="quiz"
              />
            </div>

            <Pagination
              v-if="totalPages >= 1"
              :total="filteredQuizzes.quizzes.length"
              :items-per-page="itemsPerPage"
              v-model:page="page"
              show-edges
              class="mt-4"
            >
              <PaginationContent>
                <PaginationPrevious />

                <template
                  v-for="(pageItem, index) in totalPages"
                  :key="index"
                >
                  <PaginationItem
                    :value="pageItem"
                    as-child
                  >
                    <Button
                      class="h-10 w-10 p-0"
                      :variant="pageItem === page ? 'default' : 'outline'"
                    >
                      {{ pageItem }}
                    </Button>
                  </PaginationItem>
                </template>

                <PaginationNext />
              </PaginationContent>
            </Pagination>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
