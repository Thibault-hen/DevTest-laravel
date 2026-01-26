<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { quizzes } from '@/routes';
import { Link } from '@inertiajs/vue3';
import { Pointer } from 'lucide-vue-next';
const info = {
  appName: 'DevTest',
  description: 'Test tes connaissances en programmation',
  subtitle: 'Application de quiz pour les développeurs de tous niveaux.',
  buttonText: 'Explorez les quiz',
};
</script>
<template>
  <section class="relative py-24 lg:py-32">
    <div class="container mx-auto max-w-5xl px-4 text-center">
      <div class="mb-8 flex items-center justify-center gap-4">
        <div
          class="flex items-center gap-3 font-mono text-3xl font-bold text-primary sm:text-3xl md:text-4xl lg:text-5xl"
        >
          <span class="animate-pulse">></span>
          <span class="animate-blink">_</span>
        </div>
        <h1
          class="flex flex-col items-center gap-2 text-2xl font-light tracking-tight sm:text-3xl md:text-4xl lg:text-5xl"
        >
          <span
            class="title-font bg-gradient-to-r from-primary via-primary/80 to-primary bg-clip-text font-bold uppercase tracking-wider text-transparent"
          >
            {{ info.appName }}
          </span>
        </h1>
      </div>

      <!-- Subtitle with better spacing -->
      <p class="mx-auto mb-8 max-w-2xl text-base text-muted-foreground sm:text-lg md:text-xl lg:text-2xl">
        {{ info.subtitle }}
      </p>

      <!-- Description and CTA -->
      <div class="space-y-8">
        <p class="mx-auto max-w-xl text-md sm:text-lg md:text-xl">
          {{ info.description }}
        </p>
        <Pointer
          class="rotate-180 mx-auto animate-bounce"
          :size="20"
        />
        <Link :href="quizzes().url">
          <Button
            class="group relative overflow-hidden px-10 py-4 lg:py-5 text-sm shadow-lg transition-all duration-300 hover:shadow-xl hover:shadow-primary/20 lg:text-base"
            variant="primary"
          >
            <span class="relative z-10">{{ info.buttonText }}</span>
            <div
              class="absolute inset-0 -z-0 bg-gradient-to-r from-primary/0 via-white/10 to-primary/0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            ></div>
          </Button>
        </Link>
      </div>
    </div>
  </section>
</template>
