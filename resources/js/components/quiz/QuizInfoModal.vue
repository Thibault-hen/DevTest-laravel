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
import { Info } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps<{
  modelValue: boolean;
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
    <DialogContent class="max-w-xl">
      <DialogHeader>
        <DialogTitle class="text-xl font-bold flex gap-2 items-center py-3">
          <Info class="text-primary p-1.5 h-8 w-8 rounded" /> Attention avant de commencer !
        </DialogTitle>

        <DialogDescription class="space-y-4 text-base">
          <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded">
            <p class="font-semibold text-red-800 dark:text-red-300 mb-2">⚠️ Règles importantes du quiz :</p>
            <ul class="list-disc list-inside space-y-2 text-red-700 dark:text-red-400 text-sm">
              <li>Si vous <strong>fermez la page</strong>, le quiz complet sera compté comme nul (0%)</li>
              <li>
                Si vous <strong>quittez plusieurs fois la page</strong>, la question actuelle sera automatiquement
                comptée comme
                <strong>fausse</strong>
              </li>
            </ul>
          </div>

          <div class="bg-primary/10 border-l-4 border-primary p-3 rounded">
            <p class="text-primary text-sm font-medium">
              💡 <strong>Conseil :</strong> Assurez-vous d'avoir suffisamment de temps et une connexion stable avant de
              commencer.
            </p>
          </div>
        </DialogDescription>
      </DialogHeader>

      <DialogFooter class="gap-2 sm:gap-2">
        <Button
          variant="outline"
          @click="closeDialog"
          >Annuler</Button
        >
        <Button>Je comprends, commencer le quiz</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
