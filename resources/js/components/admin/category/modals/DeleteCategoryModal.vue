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
import { useCategoryAdminForm } from '@/composables/Admin/useCategoryAdminForm';
import { CategoryData } from '@/types/generated';
import { TriangleAlert } from 'lucide-vue-next';

const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};

const { deleteCategory } = useCategoryAdminForm(closeDialog);

const props = defineProps<{
  category: CategoryData | null;
}>();

const handleDelete = (): void => {
  if (!props.category) return;
  deleteCategory(props.category.id);
};
</script>

<template>
  <AlertDialog v-model:open="model">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle class="flex gap-2 items-center">
          <TriangleAlert class="w-6 h-6 text-destructive" /> Supprimer la catégorie {{ props.category?.title }} ?
        </AlertDialogTitle>
        <AlertDialogDescription>
          Cette action est irréversible. Cela supprimera définitivement cette catégorie.
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel
          variant="outline"
          @click="closeDialog"
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
