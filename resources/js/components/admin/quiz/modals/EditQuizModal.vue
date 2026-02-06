<script setup lang="ts">
import DifficultyBadge from '@/components/shared/badges/DifficultyBadge.vue';
import HeadingSmall from '@/components/shared/HeadingSmall.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogTitle,
} from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import MultiSelect from '@/components/ui/multi-select/MultiSelect.vue';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group/';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import Switch from '@/components/ui/switch/Switch.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { useQuizAdminForm } from '@/composables/Admin/useQuizAdminForm';
import { quizConfig } from '@/constants/quizConfig';
import { CategoryData, DifficultyData, QuizData, ThemeData } from '@/types/generated';
import { LoaderCircle } from 'lucide-vue-next';

const model = defineModel<boolean>();

const closeDialog = (): void => {
  model.value = false;
};

const props = defineProps<{
  quiz: QuizData | null;
  difficulties: DifficultyData[];
  themes: ThemeData[];
  categories: CategoryData[];
}>();

const { editForm, themeOptions, updateQuiz } = useQuizAdminForm(closeDialog, props.themes, () => props.quiz);

const handleEdit = (): void => {
  if (!props.quiz) return;
  updateQuiz(props.quiz.id);
};
</script>

<template>
  <Dialog v-model:open="model">
    <DialogContent class="sm:max-w-[900px] max-h-[90vh] flex flex-col p-0">
      <form
        @submit.prevent="handleEdit"
        class="flex w-full flex-col gap-6 overflow-hidden"
      >
        <Tabs
          default-value="information"
          orientation="vertical"
          class="flex w-full gap-4 overflow-hidden"
        >
          <TabsList class="flex flex-col justify-start bg-transparent items-start p-6 pb-0">
            <header class="flex flex-col border-b pb-4 mb-4 w-full gap-1">
              <DialogTitle class="text-lg font-semibold dark:text-white">
                Editer le quiz {{ props.quiz?.title }}
              </DialogTitle>
              <DialogDescription class="text-sm text-muted-foreground">
                Modifiez les informations du quiz ainsi que les questions et réponses.
              </DialogDescription>
            </header>
            <TabsTrigger
              value="information"
              class="cursor-pointer uppercase text-sm font-bold w-full"
            >
              Informations quiz
            </TabsTrigger>
            <TabsTrigger
              value="q&a"
              class="cursor-pointer uppercase text-sm font-bold w-full"
            >
              Questions & Réponses
            </TabsTrigger>
            <p
              v-if="editForm.errors.questions"
              class="text-red-500 text-sm"
            >
              {{ editForm.errors.questions }}
            </p>
          </TabsList>

          <section class="w-full border-l overflow-hidden flex flex-col min-h-0">
            <TabsContent
              value="information"
              class="overflow-y-auto m-0 p-6"
            >
              <Card class="bg-transparent border-none !shadow-none">
                <CardHeader class="px-0 pt-0">
                  <CardTitle>
                    <HeadingSmall
                      title="Information"
                      description="Entrez les informations du quiz."
                    />
                  </CardTitle>
                </CardHeader>
                <CardContent class="grid gap-6 px-0">
                  <fieldset class="grid gap-3">
                    <Label for="title">Titre</Label>
                    <Input
                      id="title"
                      v-model="editForm.title"
                      placeholder="Entrez le titre..."
                    />
                    <p
                      v-if="editForm.errors.title"
                      class="text-red-500 text-sm"
                    >
                      {{ editForm.errors.title }}
                    </p>
                  </fieldset>

                  <fieldset class="grid gap-3">
                    <Label for="description">Description</Label>
                    <Input
                      id="description"
                      v-model="editForm.description"
                      placeholder="Entrez la description..."
                    />
                    <p
                      v-if="editForm.errors.description"
                      class="text-red-500 text-sm"
                    >
                      {{ editForm.errors.description }}
                    </p>
                  </fieldset>

                  <fieldset class="grid gap-3">
                    <Label for="difficulty">Difficulté</Label>
                    <Select
                      id="difficulty"
                      v-model="editForm.difficulty_id"
                    >
                      <SelectTrigger class="dark:bg-input/30">
                        <SelectValue placeholder="Selectionnez une difficulté" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectGroup>
                          <SelectLabel>Difficulté</SelectLabel>
                          <SelectItem
                            v-for="difficulty in props.difficulties"
                            :key="difficulty.id"
                            :value="difficulty.id"
                            class="hover:!bg-transparent focus:!bg-transparent"
                          >
                            <DifficultyBadge :difficulty="difficulty" />
                          </SelectItem>
                        </SelectGroup>
                      </SelectContent>
                    </Select>
                    <p
                      v-if="editForm.errors.difficulty_id"
                      class="text-red-500 text-sm"
                    >
                      {{ editForm.errors.difficulty_id }}
                    </p>
                  </fieldset>

                  <fieldset class="grid gap-3">
                    <Label for="category">Catégorie</Label>
                    <Select
                      id="category"
                      v-model="editForm.category_id"
                    >
                      <SelectTrigger class="dark:bg-input/30">
                        <SelectValue placeholder="Selectionnez une catégorie" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectGroup>
                          <SelectLabel>Catégories</SelectLabel>
                          <SelectItem
                            v-for="category in props.categories"
                            :key="category.id"
                            :value="category.id"
                          >
                            {{ category.title }}
                          </SelectItem>
                        </SelectGroup>
                      </SelectContent>
                    </Select>
                    <p
                      v-if="editForm.errors.category_id"
                      class="text-red-500 text-sm"
                    >
                      {{ editForm.errors.category_id }}
                    </p>
                  </fieldset>

                  <fieldset class="grid gap-3">
                    <Label for="themes">Thèmes</Label>
                    <MultiSelect
                      id="themes"
                      v-model="editForm.themes_ids"
                      :options="themeOptions"
                      placeholder="Sélectionnez les thèmes"
                      search-placeholder="Rechercher un thème..."
                      empty-message="Aucun thème trouvé."
                    />
                  </fieldset>

                  <fieldset class="grid gap-3">
                    <Label for="icon">
                      Icône
                      <small class="text-sm text-muted-foreground font-normal">(taille max 500KB)</small>
                    </Label>
                    <Input
                      id="icon"
                      type="file"
                      accept="image/*"
                      @change="(e: Event) => (editForm.icon = (e.target as HTMLInputElement).files?.[0] ?? null)"
                    />
                    <p
                      v-if="editForm.errors.icon"
                      class="text-red-500 text-sm"
                    >
                      {{ editForm.errors.icon }}
                    </p>
                  </fieldset>
                </CardContent>
              </Card>
            </TabsContent>

            <TabsContent
              value="q&a"
              class="overflow-y-auto m-0 p-6"
            >
              <Card class="bg-transparent border-none !shadow-none">
                <CardHeader class="px-0 pt-0">
                  <HeadingSmall
                    title="Questions et Réponses"
                    description="Remplissez les 20 questions et réponses du quiz."
                  />
                </CardHeader>
                <CardContent class="grid gap-6 px-0">
                  <article
                    class="grid gap-4 border-b pb-6 last:border-0 last:pb-0"
                    v-for="(question, qIndex) in editForm.questions"
                    :key="qIndex"
                  >
                    <header class="flex items-center justify-between gap-4">
                      <Label
                        :for="`question-${qIndex}`"
                        class="text-base font-semibold"
                      >
                        Question {{ qIndex + 1 }}
                      </Label>
                      <div class="flex items-center gap-4 flex-shrink-0">
                        <fieldset class="flex items-center gap-2">
                          <Label
                            :for="`question-${qIndex}-timer`"
                            class="text-muted-foreground text-sm whitespace-nowrap"
                          >
                            Durée (s)
                          </Label>
                          <Input
                            :id="`question-${qIndex}-timer`"
                            v-model="question.timer"
                            placeholder="15"
                            type="number"
                            :max="quizConfig.MAX_QUESTION_TIMER_S"
                            class="w-16"
                          />
                        </fieldset>
                        <fieldset class="flex items-center gap-2">
                          <Label
                            :for="`question-${qIndex}-multiple`"
                            class="text-sm text-muted-foreground whitespace-nowrap cursor-pointer"
                          >
                            Réponse multiple
                          </Label>
                          <Switch
                            :id="`question-${qIndex}-multiple`"
                            class="cursor-pointer"
                            v-model="question.is_multiple"
                          />
                        </fieldset>
                      </div>
                    </header>

                    <Input
                      :id="`question-${qIndex}`"
                      v-model="question.content"
                      placeholder="Entrez la question..."
                    />
                    <p
                      v-if="editForm.errors[`questions.${qIndex}.content`]"
                      class="text-red-500 text-sm -mt-2"
                    >
                      {{ editForm.errors[`questions.${qIndex}.content`] }}
                    </p>
                    <p
                      v-if="editForm.errors[`questions.${qIndex}.timer`]"
                      class="text-red-500 text-sm -mt-2"
                    >
                      {{ editForm.errors[`questions.${qIndex}.timer`] }}
                    </p>

                    <fieldset class="grid gap-3">
                      <legend class="text-sm font-medium mb-2">Réponses (sélectionnez la bonne réponse)</legend>

                      <RadioGroup
                        v-if="!question.is_multiple"
                        :model-value="String(question.answers.findIndex((a) => a.is_correct))"
                        @update:model-value="
                          (val: string) => {
                            question.answers.forEach((a, i) => (a.is_correct = i === Number(val)));
                          }
                        "
                        class="grid gap-3"
                      >
                        <label
                          v-for="(answer, aIndex) in question.answers"
                          :key="aIndex"
                          :for="`q${qIndex}-a${aIndex}`"
                          class="flex items-center gap-3 cursor-pointer"
                        >
                          <RadioGroupItem
                            :id="`q${qIndex}-a${aIndex}`"
                            :value="aIndex.toString()"
                          />
                          <Input
                            v-model="answer.content"
                            :placeholder="`Réponse ${aIndex + 1}`"
                            class="flex-1"
                            :class="{
                              'border-red-500': editForm.errors[`questions.${qIndex}.answers.${aIndex}.content`],
                            }"
                          />
                        </label>
                      </RadioGroup>

                      <div
                        v-else
                        class="grid gap-3"
                      >
                        <label
                          v-for="(answer, aIndex) in question.answers"
                          :key="aIndex"
                          :for="`q${qIndex}-a${aIndex}`"
                          class="flex items-center gap-3 cursor-pointer"
                        >
                          <Checkbox
                            :id="`q${qIndex}-a${aIndex}`"
                            v-model="answer.is_correct"
                          />
                          <Input
                            v-model="answer.content"
                            :placeholder="`Réponse ${aIndex + 1}`"
                            class="flex-1"
                            :class="{
                              'border-red-500': editForm.errors[`questions.${qIndex}.answers.${aIndex}.content`],
                            }"
                          />
                        </label>
                      </div>
                    </fieldset>
                  </article>
                </CardContent>
              </Card>
            </TabsContent>

            <DialogFooter class="border-t p-4">
              <div class="flex w-full items-center justify-between">
                <fieldset class="flex items-center gap-2">
                  <Switch
                    id="is-published"
                    v-model="editForm.is_published"
                    class="cursor-pointer"
                  />
                  <Label
                    for="is-published"
                    class="cursor-pointer"
                  >
                    Publié
                  </Label>
                </fieldset>

                <div class="flex gap-2">
                  <DialogClose as-child>
                    <Button
                      type="button"
                      variant="outline"
                    >
                      Annuler
                    </Button>
                  </DialogClose>

                  <Button
                    type="submit"
                    :disabled="editForm.processing"
                  >
                    <LoaderCircle
                      v-if="editForm.processing"
                      class="h-4 w-4 animate-spin mr-2"
                    />
                    Modifier le quiz
                  </Button>
                </div>
              </div>
            </DialogFooter>
          </section>
        </Tabs>
      </form>
    </DialogContent>
  </Dialog>
</template>
