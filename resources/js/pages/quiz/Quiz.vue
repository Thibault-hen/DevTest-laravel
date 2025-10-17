<script setup lang="ts">
import QuizDetails from '@/components/quiz/QuizDetails.vue';
import Breadcrumbs from '@/components/shared/Breadcrumbs.vue';
import Heading from '@/components/shared/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { home, quiz, quizzes } from '@/routes';
import { BreadcrumbItem } from '@/types';
import { QuizData } from '@/types/generated';

const props = defineProps<QuizData>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Accueil',
    href: home().url,
  },
  {
    title: 'Quizz',
    href: quizzes().url,
  },
  {
    title: props.title,
    href: quiz(props.slug).url,
  },
];

defineOptions({
  layout: AppLayout,
});
</script>

<template>
  <section class="flex flex-col px-4 py-6">
    <Breadcrumbs :breadcrumbs="breadcrumbs" />
    <div class="mt-8">
      <Heading
        :title="props.title"
        :description="`Détails sur le quiz ${props.title}`"
      />
    </div>
    <QuizDetails :quiz="props" />
  </section>
</template>
