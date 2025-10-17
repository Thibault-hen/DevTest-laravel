<script setup lang="ts">
import QuizInfoModal from '@/components/quiz/QuizInfoModal.vue';
import Ratings from '@/components/quiz/Ratings.vue';
import StarRating from '@/components/quiz/StarRating.vue';
import ContentTitle from '@/components/shared/ContentTitle.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import { useAppearance } from '@/composables/useAppearance';
import { COLORS } from '@/constants/colors';
import { login } from '@/routes';
import { QuizData } from '@/types/generated';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Calendar, ChartColumn, Clock, Gauge, Lock, Tag, User } from 'lucide-vue-next';
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

const { isDark } = useAppearance();
const props = defineProps<{
  quiz: QuizData;
}>();
</script>

<template>
  <QuizInfoModal v-model="showQuizInfoModal" />
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
              <Badge
                class="flex max-w-fit items-center gap-2 rounded-md border p-1 px-2 text-xs text-white shadow drop-shadow md:text-sm"
                :style="{
                  backgroundColor: isDark()
                    ? `${props.quiz.difficulty?.color ?? COLORS.DEFAULT}10`
                    : (props.quiz.difficulty?.color ?? COLORS.DEFAULT),
                  borderColor: props.quiz.difficulty?.color ?? COLORS.DEFAULT,
                  color: isDark() ? (props.quiz.difficulty?.color ?? COLORS.DEFAULT) : '',
                }"
                ><Gauge :size="16" />{{ props.quiz.difficulty?.level }}
              </Badge>

              <Badge
                class="flex items-center gap-2 border border-primary bg-primary/70 p-1 px-2 text-xs text-white md:text-sm dark:bg-primary/30"
                >{{ props.quiz.category?.name }}</Badge
              >
              <Badge
                v-for="theme in props.quiz.themes"
                :key="theme.id"
                variant="outline"
                class="flex items-center gap-2 border p-1 px-2 text-xs md:text-sm"
              >
                <Tag :size="16" />{{ theme.title }}
              </Badge>
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

          <div class="grid grid-cols-2 gap-6 pt-4 md:grid-cols-3">
            <div class="flex items-center gap-2 text-sm">
              <Clock class="h-4 w-4 text-muted-foreground" />
              <div>
                <p class="text-xs text-muted-foreground">Durée</p>
                <p class="font-semibold">~ {{ props.quiz.duration }} min</p>
              </div>
            </div>

            <div class="flex items-center gap-2 text-sm">
              <User class="h-4 w-4 text-muted-foreground" />
              <div>
                <p class="text-xs text-muted-foreground">Auteur</p>
                <p class="font-semibold truncate">{{ props.quiz.author?.name || 'Anonyme' }}</p>
              </div>
            </div>

            <div class="flex items-center gap-2 text-sm">
              <Calendar class="h-4 w-4 text-muted-foreground" />
              <div>
                <p class="text-xs text-muted-foreground">Publié</p>
                <p class="font-semibold">{{ props.quiz.created_at }}</p>
              </div>
            </div>

            <div class="flex items-center gap-2 text-sm md:hidden">
              <ChartColumn class="h-4 w-4 text-muted-foreground" />
              <div>
                <p class="text-xs text-muted-foreground">Note</p>
                <StarRating
                  :rating="props.quiz.average_rating ?? 0"
                  :count="props.quiz.ratings_count ?? 0"
                  :show-count="true"
                  :show-precision="true"
                />
              </div>
            </div>
          </div>

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

    <Card class="p-4">
      <ContentTitle title="Avis des développeurs ayant passé ce quiz" />
      <Ratings
        v-if="props.quiz.ratings"
        :ratings="props.quiz.ratings"
      />
      <span
        v-else
        class="text-sm text-muted-foreground text-center"
        >Aucune évaluation pour ce quiz.</span
      >
    </Card>
  </div>
</template>
