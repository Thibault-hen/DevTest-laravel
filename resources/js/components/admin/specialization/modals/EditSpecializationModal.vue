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
import { useSpecializationAdminForm } from '@/composables/Admin/useSpecializationAdminForm';
import { SpecializationData } from '@/types/generated';
import { LoaderCircle } from 'lucide-vue-next';
const model = defineModel<boolean>();

const props = defineProps<{
  specialization: SpecializationData | null;
}>();

const closeDialog = (): void => {
  model.value = false;
};

const { editForm, updateSpecialization } = useSpecializationAdminForm(closeDialog, () => props.specialization);

const handleEditSpecialization = (): void => {
  if (!props.specialization) return;
  updateSpecialization(props?.specialization.id);
};
</script>

<template>
  <Dialog v-model:open="model">
    <DialogContent class="sm:max-w-lg p-0">
      <form @submit.prevent="handleEditSpecialization">
        <DialogHeader class="pt-6 px-6">
          <DialogTitle>
            <HeadingSmall
              title="Modifier une spécialisation"
              description="Remplissez les informations de la spécialisation que vous souhaitez modifier"
            />
            <DialogDescription class="sr-only"
              >Remplissez les informations de la spécialisation que vous souhaitez modifier</DialogDescription
            >
          </DialogTitle>
        </DialogHeader>
        <div class="px-6 pb-6">
          <fieldset class="grid gap-3">
            <Label for="name">Nom</Label>
            <Input
              id="name"
              placeholder="Entrez le nom..."
              v-model="editForm.name"
            />
            <p
              v-if="editForm.errors.name"
              class="text-red-500 text-sm"
            >
              {{ editForm.errors.name }}
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
              Modifier la spécialisation
            </Button>
          </div>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
