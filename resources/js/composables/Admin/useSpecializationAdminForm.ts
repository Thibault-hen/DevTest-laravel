import { create, deleteMethod, update } from '@/routes/admin/specializations';
import { CreateOrUpdateSpecializationData, SpecializationData } from '@/types/generated';
import { errorToast, successToast } from '@/utils/toast';
import { router, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
export const useSpecializationAdminForm = (
  closeDialog?: () => void,
  specialization?: () => SpecializationData | null | undefined,
) => {
  const createForm = useForm<CreateOrUpdateSpecializationData>({
    name: '',
  });

  const editForm = useForm<CreateOrUpdateSpecializationData>({
    name: '',
  });

  watch(specialization || (() => null), (newSpecialization) => {
    if (newSpecialization) {
      editForm.name = newSpecialization.name;
    }
  });

  const createSpecialization = (): void => {
    createForm.post(create().url, {
      onSuccess: () => {
        createForm.reset();
        successToast('Spécialisation créée avec succès.');
      },
      onError: () => {
        errorToast('Une erreur est survenue lors de la création de la spécialisation.');
      },
      onFinish: () => {
        if (closeDialog) closeDialog();
      },
    });
  };

  const updateSpecialization = (specializationId: string): void => {
    editForm.put(update(specializationId).url, {
      onSuccess: () => {
        editForm.reset();
        successToast('Spécialisation mise à jour avec succès.');
        if (closeDialog) closeDialog();
      },
      onError: () => {
        errorToast('Une erreur est survenue lors de la mise à jour de la spécialisation.');
      },
    });
  };

  const deleteSpecialization = (specializationId: string): void => {
    router.delete(deleteMethod(specializationId).url, {
      onSuccess: () => {
        successToast('Spécialisation à bien été supprimée.');
        if (closeDialog) closeDialog();
      },
      onError: () => {
        errorToast('Une erreur est survenue lors de la suppression de la spécialisation.');
      },
    });
  };

  return {
    createForm,
    editForm,
    createSpecialization,
    updateSpecialization,
    deleteSpecialization,
  };
};
