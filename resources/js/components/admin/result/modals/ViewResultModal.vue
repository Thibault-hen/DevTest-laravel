<script setup lang="ts">
import ResultDetails from '@/components/quiz/result/ResultDetails.vue';
import ResultQuestionsAnswers from '@/components/quiz/result/ResultQuestionsAnswers.vue';
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
import { ResultData } from '@/types/generated';
const props = defineProps<{
  quiz_result: ResultData | null;
}>();
const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};
</script>

<template>
  <Dialog v-model:open="model">
    <DialogContent class="sm:max-w-xl p-0 lg:min-w-4xl max-h-[90vh] overflow-y-auto">
      <DialogHeader class="pt-6 px-6">
        <DialogTitle>
          <HeadingSmall
            title="Détails du résultat"
            description="Voici le résultat en détail pour ce quiz"
          />
          <DialogDescription class="sr-only">Voici le résultat en détail pour ce quiz</DialogDescription>
        </DialogTitle>
      </DialogHeader>

      <div class="px-6 flex flex-col gap-4 mb-6">
        <ResultDetails
          v-if="props.quiz_result"
          :show-return-button="false"
          :result-detail="props.quiz_result"
        />
        <ResultQuestionsAnswers
          v-if="props.quiz_result"
          :questions="props.quiz_result.results"
          :user-answers="props.quiz_result.user_answers"
        />
      </div>
      <DialogFooter class="border-t p-4">
        <div class="flex gap-2">
          <DialogClose as-child>
            <Button
              type="button"
              variant="outline"
              @click="closeDialog"
            >
              Retour
            </Button>
          </DialogClose>
        </div>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
