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

intervalId = setInterval(tick, 1000);
onBeforeUnmount(stop);

const progressPercentage = computed(() => {
  return (countdown.value / initialTime) * 100;
});

const progressColor = computed(() => {
  const p = progressPercentage.value;
  if (p > 50) return 'text-primary';
  if (p > 20) return 'text-yellow-500';
  return 'text-destructive';
});
</script>

<template>
  <div class="relative flex h-14 w-14 items-center justify-center">
    <!-- SVG Ring -->
    <svg class="absolute inset-0 h-full w-full -rotate-90 transform overflow-visible">
      <!-- Background Track -->
      <circle
        class="text-muted/20"
        stroke="currentColor"
        stroke-width="5"
        fill="transparent"
        r="24"
        cx="50%"
        cy="50%"
      />

      <!-- Progress Arc -->
      <circle
        :class="['transition-all duration-1000 ease-linear', progressColor]"
        stroke="currentColor"
        stroke-width="5"
        fill="transparent"
        r="24"
        cx="50%"
        cy="50%"
        :stroke-dasharray="2 * Math.PI * 24"
        :stroke-dashoffset="((100 - progressPercentage) / 100) * (2 * Math.PI * 24)"
      />
    </svg>

    <!-- Number Display -->
    <NumberFlow
      class="text-lg font-bold"
      :class="progressColor"
      :value="countdown"
      :plugins="[continuous]"
      :spin-timing="{ duration: 100 }"
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
