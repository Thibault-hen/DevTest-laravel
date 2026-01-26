<script setup lang="ts">
import CountCard from '@/components/homepage/CountCard.vue';
import HeroSection from '@/components/homepage/HeroSection.vue';
import IconAutoScroll from '@/components/homepage/IconAutoScroll.vue';
import QuizPreviewCard from '@/components/quiz/QuizCard.vue';
import HeadingSmall from '@/components/shared/HeadingSmall.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { HomepageCounter } from '@/types';
import type { HomeData } from '@/types/generated';
import { BookOpen, CheckCircle, Tag } from 'lucide-vue-next';
defineOptions({
  layout: AppLayout,
});

const props = defineProps<HomeData>();

const counters: HomepageCounter[] = [
  { count: props.quiz_count, label: 'Quiz Disponibles', label2: 'Quiz', icon: BookOpen },
  { count: props.quiz_completed_count, label: 'Quiz passés', label2: 'Participants', icon: CheckCircle },
  { count: props.theme_count, label: 'Thèmes différents', label2: 'Thèmes', icon: Tag },
];
</script>

<template>
  <div class="relative overflow-hidden">
    <div
      class="pointer-events-none absolute top-0 left-1/4 h-96 w-96 -translate-x-1/2 rounded-full bg-primary/5 blur-3xl"
    ></div>
    <div
      class="pointer-events-none absolute top-40 right-1/4 h-96 w-96 translate-x-1/2 rounded-full bg-primary/5 blur-3xl"
    ></div>

    <HeroSection />

    <section class="relative mx-auto py-16 lg:py">
      <div class="container mx-auto max-w-6xl px-4">
        <div class="grid grid-cols-1 place-items-center gap-6 sm:grid-cols-3 lg:gap-8">
          <CountCard
            v-for="(counter, index) in counters"
            :key="index"
            v-bind="counter"
          />
        </div>
      </div>

      <div class="max-w-8xl container mx-auto mt-20 lg:mt-28">
        <IconAutoScroll />
      </div>
    </section>

    <section class="relative flex w-full flex-col items-center justify-center gap-12 pb-20 lg:gap-16 lg:pb-32">
      <HeadingSmall
        title="Derniers Quiz"
        description="Découvrez nos derniers quiz disponibles"
        :center="true"
      />
      <div class="container mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:gap-8 xl:grid-cols-3">
          <QuizPreviewCard
            v-for="quiz in props.quizzes"
            :key="quiz.id"
            :quiz="quiz"
            class="transition-all duration-300 hover:-translate-y-1"
          />
        </div>
      </div>
    </section>
  </div>
</template>
