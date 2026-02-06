<script setup lang="ts">
import Switch from '@/components/ui/switch/Switch.vue';
import { useQuizAdminForm } from '@/composables/Admin/useQuizAdminForm';
import { PublishQuizData } from '@/types/generated';
import { ref, watch } from 'vue';
const props = defineProps<{
  quizId: string;
  initialValue: boolean;
}>();

const { setPublished } = useQuizAdminForm();
const isPublished = ref(props.initialValue);
const isProcessing = ref(false);

watch(
  () => props.initialValue,
  (newValue) => {
    isPublished.value = newValue;
  },
);

const handleToggle = async (value: boolean): Promise<void> => {
  if (isProcessing.value) return;

  isProcessing.value = true;
  const previousValue = isPublished.value;
  isPublished.value = value;

  setPublished(props.quizId, { is_published: value } as PublishQuizData, {
    onStart: () => {
      isProcessing.value = true;
    },
    onError: () => {
      isPublished.value = previousValue;
    },
    onFinish: () => {
      isProcessing.value = false;
    },
  });
};
</script>

<template>
  <Switch
    class="dark:data-[state=unchecked]:bg-red-900/40 data-[state=unchecked]:bg-red-900/60 data-[state=checked]:bg-primary"
    :model-value="isPublished"
    @update:model-value="handleToggle"
    :disabled="isProcessing"
  />
</template>
