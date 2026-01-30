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
import { useResultAdmin } from '@/composables/Admin/useResultAdmin';
import { ResultData } from '@/types/generated';
import { TriangleAlert } from 'lucide-vue-next';

const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};

const { deleteResult } = useResultAdmin(closeDialog);

const props = defineProps<{
  result: ResultData | null;
}>();

const handleDelete = (): void => {
  if (!props.result) return;
  deleteResult(props.result.id);
};
</script>

<template>
  <AlertDialog v-model:open="model">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle class="flex gap-2 items-center">
          <TriangleAlert class="w-6 h-6 text-destructive" /> Supprimer la résultat de
          {{ props.result?.user?.name }} pour le quiz {{ props.result?.quiz?.title }} ?
        </AlertDialogTitle>
        <AlertDialogDescription>
          Cette action est irréversible. Cela supprimera définitivement ce résultat.
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
