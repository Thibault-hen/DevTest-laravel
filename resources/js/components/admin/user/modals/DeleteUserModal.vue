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
import { deleteMethod } from '@/routes/admin/users';
import { UserProfileErrors } from '@/types';
import { UserData } from '@/types/generated';
import { errorToast, successToast } from '@/utils/toast';
import { router } from '@inertiajs/vue3';
import { TriangleAlert } from 'lucide-vue-next';
const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};

const props = defineProps<{
  user: UserData | null;
}>();

const handleDelete = (): void => {
  if (!props.user) return;
  router.delete(deleteMethod(props.user.id), {
    onSuccess: () => {
      successToast("L'utilisateur a bien été supprimé.");
    },
    onError: (errors: UserProfileErrors) => {
      if (errors.cannotDeleteSelf) {
        return errorToast(errors.cannotDeleteSelf);
      }
      errorToast("Une erreur est survenue lors de la suppression de l'utilisateur.");
    },
    onFinish: () => {
      closeDialog();
    },
  });
};
</script>

<template>
  <AlertDialog v-model:open="model">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle class="flex gap-2 items-center">
          <TriangleAlert class="w-6 h-6 text-destructive" /> Supprimer l'utilisateur {{ props.user?.name }} ?
        </AlertDialogTitle>
        <AlertDialogDescription>
          Cette action est irréversible. Cela supprimera définitivement les données de cet utilisateur.
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
