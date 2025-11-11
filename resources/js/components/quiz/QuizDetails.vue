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
import { BookOpen, Gamepad2, Lock } from 'lucide-vue-next';
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
    <Card class="bg-gradient-to-br from-card via-card to-primary/10 border relative mb-20">
      <div class="grid gap-0 lg:grid-cols-[280px_1fr]">
        <div class="h-full flex items-center justify-center">
          <div v-if="props.quiz.image_url">
            <img
              :src="`/${props.quiz.image_url}`"
              :alt="props.quiz.image_text || 'Quiz image'"
              class="h-32 w-32 lg:h-44 lg:w-44 rounded-md object-fit transition-transform duration-300"
            />
          </div>
          <div
            v-else
            class="flex h-32 w-32 lg:h-44 lg:w-44 items-center justify-center rounded-2xl bg-gradient-to-br from-primary/20 via-primary/10 to-primary/5 shadow-xl ring-2 ring-primary/10"
          >
            <BookOpen class="h-16 w-16 lg:h-20 lg:w-20 text-primary/30" />
          </div>
        </div>

        <div class="space-y-6 p-6 lg:p-8">
          <div class="space-y-3">
            <div class="flex flex-wrap items-center gap-2">
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

            <div class="space-y-2">
              <h1
                class="text-2xl lg:text-3xl font-bold tracking-tight bg-gradient-to-r from-foreground to-foreground/70 bg-clip-text"
              >
                {{ props.quiz.title }}
              </h1>
              <StarRating
                :rating="props.quiz.average_rating ?? 0"
                :count="props.quiz.ratings_count ?? 0"
                :show-count="true"
                :show-precision="true"
                class="inline-flex"
              />
            </div>
          </div>

          <p class="text-sm lg:text-base text-muted-foreground leading-relaxed">
            {{ props.quiz.description || 'Aucune description disponible.' }}
          </p>

          <QuizDetailsMeta :quiz="props.quiz" />

          <div
            :class="[
              'absolute inset-x-0 lg:inset-x-130 flex justify-center min-w-[360px]',
              canStartQuiz ? '-bottom-5' : ' -bottom-12',
            ]"
          >
            <div class="space-y-3 flex flex-col items-center">
              <Button
                @click="openModal"
                size="lg"
                class="w-full sm:w-auto font-semibold shadow-lg hover:shadow-xl transition-all duration-300"
                variant="primary"
                :disabled="!canStartQuiz"
              >
                <Lock
                  v-if="!canStartQuiz"
                  class="mr-2 h-4 w-4"
                />
                <Gamepad2
                  v-else
                  class="mr-2 h-4 w-4"
                />
                Commencer le quiz
              </Button>

              <p
                v-if="errorMessage"
                class="text-sm text-muted-foreground text-center"
              >
                <template v-if="!page.props.auth.user">
                  Vous devez être
                  <Link
                    class="text-primary cursor-pointer font-semibold hover:underline inline-flex items-center gap-1 transition-colors"
                    :href="login().url"
                  >
                    connecté
                  </Link>
                  pour participer à un quiz
                </template>

                <template v-else-if="!page.props.auth.user.email_verified_at">
                  Vous devez
                  <Link
                    class="text-primary cursor-pointer font-semibold hover:underline inline-flex items-center gap-1 transition-colors"
                    :href="login().url"
                  >
                    confirmer
                  </Link>
                  votre adresse email pour participer à un quiz
                </template>

                <template v-else-if="!props.quiz.is_published"> Ce quiz est encore en cours de construction </template>
              </p>
            </div>
          </div>
        </div>
      </div>
    </Card>

    <Ratings :ratings="props.quiz.ratings ?? []" />
  </div>
</template>
