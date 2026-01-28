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
import { useDifficultyAdminForm } from '@/composables/Admin/useDifficultyAdminForm';
import { DifficultyData } from '@/types/generated';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
  difficulty: DifficultyData | null;
}>();

const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};

const { editForm, updateDifficulty } = useDifficultyAdminForm(closeDialog, () => props.difficulty);

const handleEdit = () => {
  if (!props.difficulty) return;
  updateDifficulty(props.difficulty.id);
};
</script>

<template>
  <Dialog v-model:open="model">
    <DialogContent class="sm:max-w-lg p-0">
      <form @submit.prevent="handleEdit">
        <DialogHeader class="pt-6 px-6">
          <DialogTitle>
            <HeadingSmall
              title="Ajouter une difficulté"
              description="Remplissez les informations de la difficulté que vous souhaitez ajouter"
            />
            <DialogDescription class="sr-only"
              >Remplissez les informations de la difficulté que vous souhaitez ajouter</DialogDescription
            >
          </DialogTitle>
        </DialogHeader>
        <div class="px-6 pb-6">
          <fieldset class="grid gap-3">
            <Label for="level">Niveau</Label>
            <Input
              id="level"
              placeholder="Entrez le niveau..."
              v-model="editForm.level"
            />
            <p
              v-if="editForm.errors.level"
              class="text-red-500 text-sm"
            >
              {{ editForm.errors.level }}
            </p>
          </fieldset>
        </div>

        <div class="px-6 pb-6">
          <fieldset class="grid gap-3">
            <Label for="color">Couleur</Label>
            <Input
              id="color"
              placeholder="Entrez la couleur..."
              type="color"
              v-model="editForm.color!"
            />
            <p
              v-if="editForm.errors.color"
              class="text-red-500 text-sm"
            >
              {{ editForm.errors.color }}
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
              Modifier la difficulté
            </Button>
          </div>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
