<script setup lang="ts">
import RatingStarSelector from '@/components/quiz/result/Rating/RatingStarSelector.vue';
import Button from '@/components/ui/button/Button.vue';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { store } from '@/routes/rating';
import type { RatingErrors } from '@/types';
import { QuizData, RatingPostData } from '@/types/generated';
import { errorToast, successToast } from '@/utils/toast';
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps<{
  quiz: QuizData;
}>();

const MAX_LENGTH = 300;

const remainingCharacters = ref(MAX_LENGTH);

const form = useForm<RatingPostData>({
  comment: '',
  score: 1,
  quiz_id: props.quiz.id,
});

const setRatingScore = (score: number): void => {
  form.score = score;
};

const getRemainingCharacters = (comment: string): number => {
  return MAX_LENGTH - comment.length;
};

watch(
  () => form.comment,
  (newComment) => {
    if (newComment) {
      remainingCharacters.value = getRemainingCharacters(newComment);
    }
  },
);

const open = ref(true);

const closeDialog = (): void => {
  open.value = false;
};

const handleSubmit = (): void => {
  form.post(store().url, {
    onSuccess() {
      successToast('Votre évaluation a bien été enregistrée', { title: 'Merci' });
      closeDialog();
    },
    onError(errors: RatingErrors) {
      if (errors.ratingAlreadyExists) {
        return errorToast(errors.ratingAlreadyExists);
      }
      errorToast("Une erreur est survenue lors de la création de l'évaluation.");
    },
  });
};
</script>

<template>
  <Dialog v-model:open="open">
    <DialogContent class="max-w-xl p-6">
      <form @submit.prevent="handleSubmit">
        <DialogHeader class="flex">
          <DialogTitle class="font-bold flex gap-2 items-center py-3 justify-center">
            <span>Évaluer le quiz "{{ props.quiz.title }}" ?</span>
          </DialogTitle>

          <DialogDescription class="space-y-4 flex flex-col">
            <RatingStarSelector
              v-model="form.score"
              class="self-center"
              @update:model-value="setRatingScore"
            />
            <div class="flex space-y-2 flex-col">
              <Label
                for="comment"
                class="font-medium"
                >Laissez un commentaire (optionnel)</Label
              >
              <Textarea
                id="comment"
                v-model="form.comment!"
              />
              <span class="text-sm self-end">{{ remainingCharacters }} caractères restants</span>
            </div>
          </DialogDescription>
        </DialogHeader>

        <DialogFooter class="gap-2 sm:gap-2 rounded-b-lg mt-4">
          <Button
            type="button"
            variant="outline"
            @click="closeDialog"
            >Retour</Button
          >
          <Button
            type="submit"
            variant="primary"
            >Évaluer</Button
          >
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
