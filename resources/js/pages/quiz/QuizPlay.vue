<script setup lang="ts">
import QuizPlayCard from '@/components/quiz/play/QuizPlayCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { QuizPlayData } from '@/types/generated';
import NumberFlow, { continuous } from '@number-flow/vue';
import { ref } from 'vue';

defineOptions({
  layout: AppLayout,
});

const props = defineProps<QuizPlayData>();

const INITIAL_COUNTDOWN = 5;
const counter = ref(INITIAL_COUNTDOWN);
const hasStarted = ref(false);

const countdownInterval = setInterval(() => {
  if (counter.value > 0) {
    counter.value--;
  } else {
    clearInterval(countdownInterval);
    hasStarted.value = true;
  }
}, 1000);
</script>

<template>
  <div
    class="relative min-h-[85vh] w-full max-w-7xl mx-auto flex flex-col justify-center overflow-hidden px-4 md:px-8 mt-8 md:mt-0"
  >
    <Transition
      name="fade-scale"
      mode="out-in"
    >
      <div
        v-if="!hasStarted"
        class="flex flex-col items-center justify-center space-y-8 text-center"
      >
        <div class="space-y-4 max-w-2xl">
          <h1 class="text-4xl font-extrabold tracking-tight lg:text-5xl text-balance">
            {{ props.title }}
          </h1>
          <p class="text-muted-foreground text-lg text-pretty">
            {{ props.description }}
          </p>
        </div>

        <div class="flex flex-col items-center gap-2">
          <p class="text-sm uppercase tracking-widest text-muted-foreground font-medium">Début dans</p>
          <NumberFlow
            class="font-mono text-8xl font-bold tracking-tighter text-primary md:text-9xl"
            :value="counter"
            :plugins="[continuous]"
            :spin-timing="{ duration: 150 }"
          />
        </div>
      </div>

      <div
        v-else
        class="w-full"
      >
        <QuizPlayCard :quiz="props" />
      </div>
    </Transition>
  </div>
</template>

<style scoped>
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition:
    opacity 0.2s ease,
    transform 0.2s ease;
}

.fade-scale-enter-from {
  opacity: 0;
  transform: scale(0.95);
}

.fade-scale-leave-to {
  opacity: 0;
  transform: scale(1.05);
}
</style>
