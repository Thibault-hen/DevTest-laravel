import { create, deleteMethod, update } from '@/routes/admin/themes';
import { CreateOrUpdateThemeData, ThemeData } from '@/types/generated';
import { errorToast, successToast } from '@/utils/toast';
import { router, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

export function useThemeAdminForm(closeDialog?: () => void, theme?: () => ThemeData | null | undefined) {
  const createForm = useForm<CreateOrUpdateThemeData>({
    title: '',
  });

  const editForm = useForm<CreateOrUpdateThemeData>({
    title: '',
  });

  watch(theme || (() => null), (newTheme) => {
    if (newTheme) {
      editForm.reset();
      editForm.title = newTheme.title || '';
    }
  });

  const createTheme = () => {
    createForm.post(create().url, {
      onSuccess: () => {
        if (closeDialog) closeDialog();
        createForm.reset();
        successToast('Thème créé avec succès.');
      },
      onError: () => {
        errorToast('Une erreur est survenue lors de la création du thème.');
      },
    });
  };

  const updateTheme = (themeId: string) => {
    editForm.put(update(themeId).url, {
      onSuccess: () => {
        if (closeDialog) closeDialog();
        editForm.reset();
        successToast('Thème modifié avec succès.');
      },
      onError: () => {
        errorToast('Une erreur est survenue lors de la modification du thème.');
      },
    });
  };

  const deleteTheme = (themeId: string) => {
    router.delete(deleteMethod(themeId).url, {
      onSuccess: () => {
        if (closeDialog) closeDialog();
        successToast('Thème supprimé avec succès.');
      },
      onError: () => {
        errorToast('Une erreur est survenue lors de la suppression du thème.');
      },
    });
  };

  return {
    createForm,
    editForm,
    createTheme,
    updateTheme,
    deleteTheme,
  };
}
