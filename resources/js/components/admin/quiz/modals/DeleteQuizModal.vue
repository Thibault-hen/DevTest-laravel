<script setup lang="ts">
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { useQuizAdminForm } from '@/composables/Admin/useQuizAdminForm';
import { QuizData } from '@/types/generated';
import { TriangleAlert } from 'lucide-vue-next';

const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};

const { deleteQuiz } = useQuizAdminForm(closeDialog);

const props = defineProps<{
  quiz: QuizData | null;
}>();

const handleDelete = (): void => {
  if (!props.quiz) return;
  deleteQuiz(props.quiz.id);
};
</script>

<template>
  <AlertDialog v-model:open="model">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle class="flex gap-2 items-center">
          <TriangleAlert class="w-6 h-6 text-destructive" /> Supprimer le quiz {{ props.quiz?.title }} ?
        </AlertDialogTitle>
        <AlertDialogDescription>
          Cette action est irréversible. Cela supprimera définitivement ce quiz.
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel
          variant="outline"
          @click="model = false"
        >
          Annuler</AlertDialogCancel
        >
        <AlertDialogAction
          variant="destructive"
          @click="handleDelete"
          >Supprimer</AlertDialogAction
        >
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>
