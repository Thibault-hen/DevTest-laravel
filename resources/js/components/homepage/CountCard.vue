<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import type { HomepageCounter } from '@/types';
import NumberFlow, { continuous } from '@number-flow/vue';
import { onMounted, ref } from 'vue';

const animatedCount = ref(0);

onMounted(() => {
  setTimeout(() => {
    animatedCount.value = props.count;
  }, 600);
});
const props = defineProps<HomepageCounter>();
</script>

<template>
  <Card
    class="group relative w-full overflow-hidden rounded-2xl border border-primary/10 bg-gradient-to-br from-card via-card to-card/50 p-4 shadow-lg backdrop-blur-sm transition-all duration-500 hover:scale-105 hover:border-primary/30 hover:shadow-xl hover:shadow-primary/10 sm:max-w-[320px]"
  >
    <div
      class="pointer-events-none absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
    ></div>

    <div
      class="absolute -top-6 -right-6 opacity-[0.07] transition-all duration-500 group-hover:scale-110 group-hover:opacity-10"
    >
      <component
        :is="props.icon"
        v-if="props.icon"
        :stroke-width="0.5"
        class="h-24 w-24 text-primary md:h-28 md:w-28 xl:h-32 xl:w-32"
      />
    </div>

    <div class="relative z-10 flex flex-col gap-4">
      <div class="flex items-baseline gap-3">
        <NumberFlow
          class="text-2xl font-bold tracking-tight md:text-3xl"
          :value="animatedCount"
          :plugins="[continuous]"
          :spin-timing="{ duration: 1200 }"
        />
        <span class="text-sm font-semibold tracking-wider text-muted-foreground/80 uppercase">{{ props.label2 }}</span>
      </div>

      <div class="h-px w-12 bg-gradient-to-r from-primary/50 to-transparent"></div>

      <div class="flex items-center gap-2.5">
        <div class="rounded-lg bg-primary/10 p-1.5">
          <component
            :is="props.icon"
            v-if="props.icon"
            :stroke-width="2"
            class="h-4 w-4 text-primary"
          />
        </div>
        <p class="text-sm font-medium text-muted-foreground/90">
          {{ props.label }}
        </p>
      </div>
    </div>
  </Card>
</template>
