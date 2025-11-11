<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { quizzes } from '@/routes';
import { Link } from '@inertiajs/vue3';
const info = {
  title: 'Bienvenue sur',
  appName: 'DevTest',
  description: 'Test tes connaissances en programmation !',
  subtitle: 'Application de quiz pour les développeurs de tous niveaux.',
  buttonText: 'Explorez les quiz',
};
</script>
<template>
  <section class="py-20">
    <div class="mx-auto text-center">
      <div class="mb-6 flex items-center justify-center gap-2 text-2xl sm:text-3xl md:text-4xl lg:text-5xl">
        <div class="flex items-center font-mono font-bold text-primary">
          <span>></span>
          <span class="animate-blink">_</span>
        </div>
        <h1>
          {{ info.title }}
          <span class="title-font text-lg font-semibold tracking-widest uppercase md:text-3xl lg:text-2xl">
            {{ info.appName }}
          </span>
        </h1>
      </div>

      <p class="mb-6 text-sm text-muted-foreground sm:text-base md:text-xl">
        {{ info.subtitle }}
      </p>

      <div class="space-y-6">
        <p class="text-sm sm:text-base md:text-xl">{{ info.description }}</p>
        <Link :href="quizzes().url">
          <Button
            class="px-8 py-3"
            variant="primary"
            >{{ info.buttonText }}</Button
          >
        </Link>
      </div>
    </div>
  </section>
</template>
