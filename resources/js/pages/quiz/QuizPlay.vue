<script setup lang="ts">
import QuizPlayCard from '@/components/quiz/play/QuizPlayCard.vue';
import Heading from '@/components/shared/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { QuizPlayData } from '@/types/generated';
import NumberFlow, { continuous } from '@number-flow/vue';
import { ref } from 'vue';

const props = defineProps<QuizPlayData>();

const INITIAL_COUNTDOWN: number = 5;
const counter = ref(INITIAL_COUNTDOWN);

const quizRefElement = ref<HTMLElement | null>(null);

const startQuiz = () => {
  clearInterval(countdownInterval);
  quizRefElement.value?.scrollIntoView({ behavior: 'smooth' });
};

const countdownInterval = setInterval(() => {
  if (counter.value > 0) {
    counter.value--;
    return;
  }
  startQuiz();
}, 1000);

defineOptions({
  layout: AppLayout,
});
console.log(props);
</script>

<template>
  <section class="flex flex-col px-4 py-6">
    <div>
      <Heading
        :title="props.title"
        :description="props.description"
      />

      <div
        v-if="counter > 0"
        class="flex flex-col items-center justify-center space-y-4 mt-40"
      >
        <p class="text-lg md:text-xl lg:text-2xl">Le quiz commence dans :</p>
        <NumberFlow
          class="text-xl md:text-6xl"
          :value="counter"
          :plugins="[continuous]"
          :spin-timing="{
            duration: 100,
          }"
        />
      </div>

      <Transition
        v-else
        name="start"
        mode="out-in"
        appear
      >
        <div ref="quizRefElement">
          <QuizPlayCard :quiz="props" />
        </div>
      </Transition>
    </div>
  </section>
</template>

<style scoped>
.start-enter-active,
.start-leave-active {
  transition: all 0.3s ease;
}

.start-enter-to,
.start-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.start-enter-from,
.start-leave-to {
  opacity: 0;
  transform: translateY(30px);
}
</style>
