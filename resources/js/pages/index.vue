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
  <div>
    <HeroSection />
    <section class="mx-auto py-6">
      <div class="container mx-auto max-w-4xl px-4">
        <div class="grid grid-cols-1 place-items-center gap-4 sm:grid-cols-3">
          <CountCard
            v-for="(counter, index) in counters"
            :key="index"
            v-bind="counter"
          />
        </div>
      </div>
      <div class="max-w-8xl container mx-auto my-14">
        <IconAutoScroll />
      </div>
    </section>

    <section class="flex w-full flex-col items-center justify-center gap-8">
      <HeadingSmall
        title="Derniers Quiz"
        description="Découvrez nos derniers quiz disponibles"
        :center="true"
      />
      <div
        class="grid w-full grid-cols-1 gap-4 md:grid-cols-2 md:place-items-center md:gap-6 xl:grid-cols-3 xl:gap-6 [&>*:nth-child(3)]:md:col-span-2 [&>*:nth-child(3)]:xl:col-span-1"
      >
        <QuizPreviewCard
          v-for="quiz in props.quizzes"
          :key="quiz.id"
          :quiz="quiz"
        />
      </div>
    </section>
  </div>
</template>
