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
import { useThemeAdminForm } from '@/composables/Admin/useThemeAdminForm';
import { LoaderCircle } from 'lucide-vue-next';

const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};

const { createForm, createTheme } = useThemeAdminForm(closeDialog);
</script>

<template>
  <Dialog v-model:open="model">
    <DialogContent class="sm:max-w-lg p-0">
      <form @submit.prevent="createTheme">
        <DialogHeader class="pt-6 px-6">
          <DialogTitle>
            <HeadingSmall
              title="Ajouter un thème"
              description="Remplissez les informations du thème que vous souhaitez ajouter"
            />
            <DialogDescription class="sr-only"
              >Remplissez les informations du thème que vous souhaitez ajouter</DialogDescription
            >
          </DialogTitle>
        </DialogHeader>
        <div class="px-6 pb-6">
          <fieldset class="grid gap-3">
            <Label for="title">Titre</Label>
            <Input
              id="title"
              placeholder="Entrez le titre..."
              v-model="createForm.title"
            />
            <p
              v-if="createForm.errors.title"
              class="text-red-500 text-sm"
            >
              {{ createForm.errors.title }}
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
              variant="primary"
              class="px-8 min-w-[150px]"
              :disabled="createForm.processing"
            >
              <template v-if="createForm.processing">
                <LoaderCircle class="animate-spin w-5 h-5" />
              </template>
              <template v-else> Créer le thème </template>
            </Button>
          </div>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
