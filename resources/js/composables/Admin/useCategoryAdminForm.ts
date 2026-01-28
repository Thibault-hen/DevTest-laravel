import { create, deleteMethod, update } from '@/routes/admin/categories';
import { CategoryData, CreateOrUpdateCategoryData } from '@/types/generated';
import { errorToast, successToast } from '@/utils/toast';
import { router, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

export const useCategoryAdminForm = (closeDialog?: () => void, category?: () => CategoryData | null | undefined) => {
  const createForm = useForm<CreateOrUpdateCategoryData>({
    title: '',
  });

  const editForm = useForm<CreateOrUpdateCategoryData>({
    title: '',
  });

  watch(category || (() => null), (newCategory) => {
    if (newCategory) {
      editForm.reset();
      editForm.title = newCategory.title || '';
    }
  });

  const createCategory = () => {
    createForm.post(create().url, {
      onSuccess: () => {
        if (closeDialog) closeDialog();
        createForm.reset();
        successToast('Catégorie créée avec succès.');
      },
      onError: () => {
        if (closeDialog) closeDialog();
        errorToast('Une erreur est survenue lors de la création de la catégorie.');
      },
    });
  };

  const updateCategory = (categoryId: string) => {
    editForm.put(update(categoryId).url, {
      onSuccess: () => {
        if (closeDialog) closeDialog();
        editForm.reset();
        successToast('Catégorie mise à jour avec succès.');
      },
      onError: () => {
        errorToast('Une erreur est survenue lors de la mise à jour de la catégorie.');
      },
    });
  };

  const deleteCategory = (categoryId: string) => {
    router.delete(deleteMethod(categoryId).url, {
      onSuccess: () => {
        if (closeDialog) closeDialog();
        successToast('La catégorie a été supprimée avec succès.');
      },
      onError: () => {
        errorToast('Une erreur est survenue lors de la suppression de la catégorie.');
      },
    });
  };

  return {
    createForm,
    editForm,
    createCategory,
    updateCategory,
    deleteCategory,
  };
};
