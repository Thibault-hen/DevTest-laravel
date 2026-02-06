<script setup lang="ts">
import DataTable from '@/components/admin/DataTable.vue';
import { quizColumns } from '@/components/admin/quiz/Column';
import { AddQuizModal, DeleteQuizModal, EditQuizModal } from '@/components/admin/quiz/modals';
import Button from '@/components/ui/button/Button.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { CategoryData, DifficultyData, QuizData, ThemeData } from '@/types/generated';
import { Head } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

const showAddModal = ref(false);
const showDeleteModal = ref(false);
const showEditModal = ref(false);
const selectedQuiz = ref<QuizData | null>(null);

const props = defineProps<{
  quizzes: QuizData[];
  themes: ThemeData[];
  categories: CategoryData[];
  difficulties: DifficultyData[];
}>();

const openAddModal = (): void => {
  showAddModal.value = true;
};

const openDeleteModal = (quiz: QuizData): void => {
  selectedQuiz.value = quiz;
  showDeleteModal.value = true;
};

const openEditModal = (quiz: QuizData): void => {
  selectedQuiz.value = quiz;
  showEditModal.value = true;
};
</script>

<template>
  <AddQuizModal
    v-model="showAddModal"
    :themes="props.themes"
    :categories="props.categories"
    :difficulties="props.difficulties"
  />
  <DeleteQuizModal
    v-model="showDeleteModal"
    :quiz="selectedQuiz"
  />
  <EditQuizModal
    v-model="showEditModal"
    :quiz="selectedQuiz"
    :themes="props.themes"
    :categories="props.categories"
    :difficulties="props.difficulties"
  />
  <AdminLayout>
    <template #header-actions>
      <Button
        size="sm"
        variant="primary"
        @click="openAddModal"
      >
        <Plus class="w-4 h-4 mr-2" />
        Ajouter un quiz
      </Button>
    </template>

    <Head title="Quiz" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <DataTable
        :data="props.quizzes"
        :columns="quizColumns"
        :meta="{ onOpenDelete: openDeleteModal, onOpenEdit: openEditModal }"
      />
    </div>
  </AdminLayout>
</template>
