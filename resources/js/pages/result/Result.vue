<script setup lang="ts">
import QuickSummary from '@/components/quiz/result/QuickSummary.vue';
import RatingModal from '@/components/quiz/result/Rating/RatingModal.vue';
import ResultDetails from '@/components/quiz/result/ResultDetails.vue';
import ResultQuestionsAnswers from '@/components/quiz/result/ResultQuestionsAnswers.vue';
import Breadcrumbs from '@/components/shared/Breadcrumbs.vue';
import Heading from '@/components/shared/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { home, quiz, quizzes } from '@/routes';
import { BreadcrumbItem, FlashMessage } from '@/types';
import { ResultData } from '@/types/generated';
import { successToast } from '@/utils/toast';
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';

defineOptions({
  layout: AppLayout,
});

const props = defineProps<{
  quiz_result: ResultData;
}>();

const page = usePage();
const pageProps = page.props as FlashMessage;
const currentUrl = page.url as string;

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
    title: props.quiz_result.quiz.title,
    href: quiz(props.quiz_result.quiz.slug).url,
  },
  {
    title: 'Résultat',
    href: currentUrl,
  },
];

watch(
  () => pageProps.flash?.success,
  (newMessage) => {
    if (newMessage) {
      successToast('Quiz terminé', newMessage);
    }
  },
  { immediate: true },
);
</script>

<template>
  <RatingModal
    v-if="!props.quiz_result.user_rating"
    :quiz="props.quiz_result.quiz"
  />
  <section class="flex flex-col px-4 py-6">
    <Breadcrumbs :breadcrumbs="breadcrumbs" />
    <div class="mt-8">
      <Heading
        :title="`Résultat quiz`"
        :description="`Voici le détail de vos résultats pour le quiz ${props.quiz_result.quiz.title}`"
      />
    </div>
    <section class="flex flex-col xl:flex-row gap-4 mt-4">
      <QuickSummary
        :summary="props.quiz_result.results"
        class="w-full xl:w-1/3"
      />

      <div class="flex flex-col gap-4 w-full xl:w-2/3">
        <ResultDetails :result-detail="props.quiz_result" />
        <ResultQuestionsAnswers
          :questions="props.quiz_result.results"
          :user-answers="props.quiz_result.user_answers"
        />
      </div>
    </section>
  </section>
</template>
