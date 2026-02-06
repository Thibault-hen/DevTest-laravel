import { create, deleteMethod, update } from '@/routes/admin/difficulties';
import { CreateOrUpdateDifficultyData, DifficultyData } from '@/types/generated';
import { errorToast, successToast } from '@/utils/toast';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

export const useDifficultyAdminForm = (
  closeDialog?: () => void,
  difficulty?: () => DifficultyData | null | undefined,
) => {
  const createForm = useForm<CreateOrUpdateDifficultyData>({
    level: '',
    color: '#000000',
  });

  const editForm = useForm<CreateOrUpdateDifficultyData>({
    level: '',
    color: '#000000',
  });

  watch(difficulty || (() => null), (newDifficulty) => {
    if (newDifficulty) {
      editForm.reset();
      editForm.level = newDifficulty.level || '';
      editForm.color = newDifficulty.color || '#000000';
    }
  });

  const createDifficulty = () => {
    createForm.post(create().url, {
      onSuccess: () => {
        if (closeDialog) closeDialog();
        createForm.reset();
        successToast('La difficulté a été créée avec succès.');
      },
      onError: () => {
        errorToast('Un erreur est survenue lors de la création de la difficulté.');
      },
    });
  };

  const updateDifficulty = (difficultyId: string) => {
    editForm.put(update(difficultyId).url, {
      onSuccess: () => {
        if (closeDialog) closeDialog();
        editForm.reset();
        successToast('La difficulté a été mise à jour avec succès.');
      },
      onError: () => {
        errorToast('Un erreur est survenue lors de la mise à jour de la difficulté.');
      },
    });
  };

  const deleteDifficulty = (difficultyId: string) => {
    editForm.delete(deleteMethod(difficultyId).url, {
      onSuccess: () => {
        if (closeDialog) closeDialog();
        successToast('La difficulté a été supprimée avec succès.');
      },
      onError: () => {
        errorToast('Un erreur est survenue lors de la suppression de la difficulté.');
      },
    });
  };

  return {
    createForm,
    createDifficulty,
    editForm,
    updateDifficulty,
    deleteDifficulty,
  };
};
