<script setup lang="ts">
import HeadingSmall from '@/components/shared/HeadingSmall.vue';
import Button from '@/components/ui/button/Button.vue';
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { useCategoryAdminForm } from '@/composables/Admin/useCategoryAdminForm';
import { CategoryData } from '@/types/generated';
import { LoaderCircle } from 'lucide-vue-next';
const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};

const props = defineProps<{
  category: CategoryData | null;
}>();

const { editForm, updateCategory } = useCategoryAdminForm(closeDialog, () => props.category);

const handleEdit = () => {
  if (!props.category) return;
  updateCategory(props.category.id);
};
</script>

<template>
  <Dialog v-model:open="model">
    <DialogContent class="sm:max-w-lg p-0">
      <form @submit.prevent="handleEdit">
        <DialogHeader class="pt-6 px-6">
          <DialogTitle>
            <HeadingSmall
              title="Modifier une catégorie"
              description="Remplissez les informations de la catégorie que vous souhaitez modifier"
            />
            <DialogDescription class="sr-only"
              >Remplissez les informations de la catégorie que vous souhaitez modifier</DialogDescription
            >
          </DialogTitle>
        </DialogHeader>
        <div class="px-6 pb-6">
          <fieldset class="grid gap-3">
            <Label for="title">Titre</Label>
            <Input
              id="title"
              placeholder="Entrez le titre..."
              v-model="editForm.title"
            />
            <p
              v-if="editForm.errors.title"
              class="text-red-500 text-sm"
            >
              {{ editForm.errors.title }}
            </p>
          </fieldset>
        </div>

        <DialogFooter class="border-t p-4">
          <div class="flex gap-2">
            <DialogClose as-child>
              <Button
                type="button"
                variant="outline"
                @click="closeDialog"
              >
                Annuler
              </Button>
            </DialogClose>

            <Button
              type="submit"
              :disabled="editForm.processing || !editForm.isDirty"
            >
              <LoaderCircle
                v-if="editForm.processing"
                class="h-4 w-4 animate-spin mr-2"
              />
              Modifier la catégorie
            </Button>
          </div>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
