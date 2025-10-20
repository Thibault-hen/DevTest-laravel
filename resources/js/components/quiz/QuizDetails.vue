<script setup lang="ts">
import CategoryBadge from '@/components/quiz/badges/CategoryBadge.vue';
import DifficultyBadge from '@/components/quiz/badges/DifficultyBadge.vue';
import ThemeBadge from '@/components/quiz/badges/ThemeBadge.vue';
import UnavailableBadge from '@/components/quiz/badges/UnavailableBadge.vue';
import QuizDetailsMeta from '@/components/quiz/QuizDetailsMeta.vue';
import QuizInfoModal from '@/components/quiz/QuizInfoModal.vue';
import Ratings from '@/components/quiz/rating/Ratings.vue';
import StarRating from '@/components/quiz/rating/StarRating.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import { login } from '@/routes';
import { QuizData } from '@/types/generated';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Lock } from 'lucide-vue-next';
import { computed, ref } from 'vue';
const page = usePage();

const showQuizInfoModal = ref(false);

const openModal = (): void => {
  showQuizInfoModal.value = true;
};

const canStartQuiz = computed(() => {
  return page.props.auth.user && page.props.auth.user?.email_verified_at && props.quiz.is_published;
});

const errorMessage = computed(() => {
  if (!page.props.auth.user) {
    return true;
  }
  if (!page.props.auth.user.email_verified_at) {
    return true;
  }
  if (!props.quiz.is_published) {
    return true;
  }
  return false;
});

const props = defineProps<{
  quiz: QuizData;
}>();
</script>

<template>
  <QuizInfoModal
    v-model="showQuizInfoModal"
    :quiz-name="props.quiz.slug"
  />
  <div class="mx-auto min-w-full xl:min-w-5xl xl:max-w-5xl space-y-6">
    <Card class="overflow-hidden p-2 py-6 md:p-6">
      <div class="grid gap-2 lg:gap-6 md:grid-cols-1 lg:grid-cols-3">
        <div class="relative lg:h-64 overflow-hidden md:col-span-1 md:h-auto justify-center flex items-center">
          <img
            v-if="props.quiz.image_url"
            :src="`/${props.quiz.image_url}`"
            :alt="props.quiz.image_text || 'Quiz image'"
            class="h-16 w-16 sm:h-32 sm:w-32 lg:h-46 lg:w-46 rounded-lg mx-auto"
          />
          <div
            v-else
            class="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary/20 to-primary/5"
          >
            <BookOpen class="h-20 w-20 text-primary/40" />
          </div>
        </div>

        <div class="space-y-4 p-6 md:col-span-2">
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <UnavailableBadge v-if="!props.quiz.is_published" />

              <DifficultyBadge
                v-if="props.quiz?.difficulty"
                :difficulty="props.quiz.difficulty"
              />

              <CategoryBadge
                v-if="props.quiz.category"
                :category="props.quiz.category"
              />

              <ThemeBadge
                v-if="props.quiz.themes"
                :themes="props.quiz.themes"
              />
            </div>

            <div class="flex gap-4 items-center">
              <span class="text-xl font-bold tracking-tight lg:text-2xl">
                {{ props.quiz.title }}
              </span>
              <StarRating
                :rating="props.quiz.average_rating ?? 0"
                :count="props.quiz.ratings_count ?? 0"
                :show-count="true"
                :show-precision="true"
                class="hidden md:inline-flex"
              />
            </div>
          </div>

          <p class="text-sm md:text-base text-muted-foreground leading-relaxed">
            {{ props.quiz.description || 'Aucune description disponible.' }}
          </p>

          <QuizDetailsMeta :quiz="props.quiz" />

          <div class="pt-4 flex md:justify-center lg:justify-start">
            <div class="space-y-2 flex flex-col md:w-fit w-full">
              <Button
                @click="openModal"
                size="lg"
                class="w-full md:w-auto"
                :disabled="!canStartQuiz"
              >
                <Lock v-if="!canStartQuiz" />
                Commencer le quiz
              </Button>

              <span
                v-if="errorMessage"
                class="text-sm text-muted-foreground text-center"
              >
                <template v-if="!page.props.auth.user">
                  Vous devez être
                  <Link
                    class="text-primary cursor-pointer font-semibold hover:underline"
                    :href="login().url"
                  >
                    connecté
                  </Link>
                  pour participer à un quiz
                </template>

                <template v-else-if="!page.props.auth.user.email_verified_at">
                  Vous devez
                  <Link
                    class="text-primary cursor-pointer font-semibold hover:underline"
                    :href="login().url"
                  >
                    confirmer
                  </Link>
                  votre adresse email pour participer à un quiz
                </template>
                <template v-else-if="!props.quiz.is_published"> Ce quiz est encore en cours de construction </template>
              </span>
            </div>
          </div>
        </div>
      </div>
    </Card>

    <Ratings :ratings="props.quiz.ratings ?? []" />
  </div>
</template>
