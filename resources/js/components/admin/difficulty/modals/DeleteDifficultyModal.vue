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
import { useDifficultyAdminForm } from '@/composables/Admin/useDifficultyAdminForm';
import { DifficultyData } from '@/types/generated';
import { TriangleAlert } from 'lucide-vue-next';

const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};

const { deleteDifficulty } = useDifficultyAdminForm(closeDialog);

const props = defineProps<{
  difficulty: DifficultyData | null;
}>();

const handleDelete = (): void => {
  if (!props.difficulty) return;
  deleteDifficulty(props.difficulty.id);
};
</script>

<template>
  <AlertDialog v-model:open="model">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle class="flex gap-2 items-center">
          <TriangleAlert class="w-6 h-6 text-destructive" /> Supprimer la difficulté {{ props.difficulty?.level }} ?
        </AlertDialogTitle>
        <AlertDialogDescription>
          Cette action est irréversible. Cela supprimera définitivement cette difficulté.
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
