<script setup lang="ts">
import { Star } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
  modelValue: number;
}>();

const MAX_STARS: number = 5;

const selectedRating = ref<number>(props.modelValue);
const hoverValue = ref<number>(0);

const hoverRating = (value: number): void => {
  hoverValue.value = value;
};

const setRating = (value: number): void => {
  selectedRating.value = value;
  emit('update:modelValue', value);
};

const emit = defineEmits<{
  (e: 'update:modelValue', value: number): void;
}>();
</script>

<template>
  <div
    class="flex gap-2"
    @mouseleave="hoverRating(0)"
  >
    <Star
      v-for="(star, index) in Array.from({ length: MAX_STARS })"
      :key="`full-${index}`"
      :size="26"
      @mouseover="hoverRating(index + 1)"
      @click="setRating(index + 1)"
      stroke-width="0.5"
      class="cursor-pointer transition-all duration-200 hover:scale-125"
      :class="(hoverValue || selectedRating) > index ? 'filled' : ''"
    />
  </div>
</template>

<style scoped>
.filled {
  fill: #009966;
}
</style>
