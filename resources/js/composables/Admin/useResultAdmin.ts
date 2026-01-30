import { deleteMethod } from '@/routes/admin/results';
import { errorToast, successToast } from '@/utils/toast';
import { router } from '@inertiajs/vue3';

export const useResultAdmin = (closeDialog?: () => void) => {
  const deleteResult = async (resultId: string) => {
    router.delete(deleteMethod(resultId), {
      onSuccess: () => {
        if (closeDialog) closeDialog();
        successToast('Le résultat a été supprimé avec succès.');
      },
      onError: () => {
        errorToast('Une erreur est survenue lors de la suppression du résultat.');
      },
    });
  };

  return {
    deleteResult,
  };
};
