<script setup lang="ts">
import NumberFlow, { continuous } from '@number-flow/vue';
import { computed, onBeforeUnmount, ref } from 'vue';

const props = defineProps<{
  duration: number;
}>();

const emit = defineEmits<{
  timeout: [];
}>();

const countdown = ref(props.duration);
const initialTime = props.duration;

let intervalId: number | null = null;

const tick = () => {
  if (countdown.value > 0) {
    countdown.value--;
  } else {
    stop();
    emit('timeout');
  }
};

const stop = () => {
  if (intervalId) {
    clearInterval(intervalId);
    intervalId = null;
  }
};

// Start countdown
intervalId = setInterval(tick, 1000);

onBeforeUnmount(stop);

const circleDasharray = computed(() => {
  const circumference = 2 * Math.PI * 45;
  const progress = (countdown.value / initialTime) * circumference;
  return `${progress} ${circumference}`;
});
</script>

<template>
  <div class="circular-countdown w-12 h-12 lg:w-14 lg:h-14">
    <svg
      fill="var(--color-background)"
      viewBox="0 0 100 100"
      class="base-timer"
    >
      <circle
        class="base-timer__circle"
        cx="50"
        cy="50"
        r="44"
      ></circle>
      <path
        :stroke-dasharray="circleDasharray"
        class="base-timer__path-remaining"
        stroke="var(--color-primary)"
        d="
          M 50, 50
          m -45, 0
          a 45,45 0 1,0 90,0
          a 45,45 0 1,0 -90,0
        "
      ></path>
    </svg>
    <NumberFlow
      class="base-timer__label text-sm md:text-lg lg:text-xl font-bold leading-tight transition-all duration-100"
      :value="countdown"
      :plugins="[continuous]"
      :spin-timing="{
        duration: 100,
      }"
    />
  </div>
</template>

<style scoped>
.circular-countdown {
  position: relative;
}

.base-timer {
  width: 100%;
  height: 100%;
}

.base-timer__circle {
  fill: none;
  stroke: var(--color-border);
  stroke-width: 4px;
}

.base-timer__path-remaining {
  stroke-width: 4px;
  stroke-linecap: round;
  transform: rotate(90deg);
  transform-origin: center;
  transition: all 1s linear;
}

.base-timer__label {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 1.2em; /* Slightly smaller font */
}
</style>
