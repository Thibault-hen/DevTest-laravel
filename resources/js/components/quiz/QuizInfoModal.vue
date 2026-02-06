<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { play } from '@/routes/quiz';
import { Link } from '@inertiajs/vue3';
import { Info } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps<{
  modelValue: boolean;
  quizName: string;
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void;
}>();

const open = ref(props.modelValue);

const closeDialog = (): void => {
  open.value = false;
};

watch(
  () => props.modelValue,
  (val) => (open.value = val),
);
watch(open, (val) => emit('update:modelValue', val));
</script>

<template>
  <Dialog v-model:open="open">
    <DialogContent class="max-w-xl p-6">
      <DialogHeader>
        <DialogTitle class="font-bold flex gap-2 items-center py-3">
          <Info class="text-primary p-2 h-8 w-8 bg-primary/10 rounded-full" /> Attention avant de commencer !
        </DialogTitle>

        <DialogDescription class="space-y-4 text-base">
          <div class="bg-primary/10 border-l-4 border-primary p-3 rounded">
            <p class="text-primary text-sm font-medium">
              💡 <strong>Conseil :</strong> Assurez-vous d'avoir suffisamment de temps et une connexion stable avant de
              commencer.
            </p>
          </div>
        </DialogDescription>
      </DialogHeader>

      <DialogFooter class="gap-2 sm:gap-2 rounded-b-lg">
        <Button @click="closeDialog">Annuler</Button>
        <Link :href="play(props.quizName).url">
          <Button
            variant="primary"
            class="w-full"
            >Je comprends, commencer le quiz</Button
          >
        </Link>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
