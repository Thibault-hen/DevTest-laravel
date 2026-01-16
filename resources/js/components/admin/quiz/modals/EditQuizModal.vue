<script setup lang="ts">
import DifficultyBadge from '@/components/quiz/badges/DifficultyBadge.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
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
    <DialogContent class="sm:max-w-[900px] max-h-[90vh] flex flex-col">
      <form
        @submit.prevent="handleEdit"
        class="flex w-full flex-col gap-6 overflow-hidden"
      >
        <Tabs
          default-value="account"
          orientation="vertical"
          class="flex w-full gap-4 overflow-hidden"
        >
          <TabsList class="flex flex-col justify-start bg-transparent items-start">
            <div class="flex flex-col border-b p-2 mb-4 w-full gap-4">
              <DialogTitle class="text-lg font-semibold dark:text-white"
                >Editer le quiz {{ props.quiz?.title }}</DialogTitle
              >
              <DialogDescription class="text-sm text-muted-foreground">
                Modifiez les informations du quiz ainsi que les questions et réponses.
              </DialogDescription>
            </div>
            <TabsTrigger
              value="information"
              class="cursor-pointer uppercase text-sm font-bold w-full flex-col"
            >
              <div class="flex items-center justify-between">
                <span>Informations quiz</span>
              </div>
            </TabsTrigger>
            <TabsTrigger
              value="q&a"
              class="cursor-pointer uppercase text-sm font-bold"
            >
              <div class="flex flex-col items-start w-full">
                <div class="flex items-center justify-between w-full">
                  <span>Questions & Réponses</span>
                </div>
              </div>
            </TabsTrigger>
          </TabsList>
          <div class="w-full border bg-background rounded-lg overflow-hidden flex flex-col min-h-0">
            <TabsContent
              value="information"
              class="overflow-y-auto m-0"
            >
              <Card class="bg-transparent border-none !shadow-none">
                <CardHeader>
                  <CardTitle>Information</CardTitle>
                  <CardDescription> Entrez les informations du quiz.</CardDescription>
                </CardHeader>
                <CardContent class="grid gap-6">
                  <div class="grid gap-3">
                    <Label for="title">Titre</Label>
                    <Input
                      id="title"
                      v-model="editForm.title"
                    />
                    <p
                      v-if="editForm.errors.title"
                      class="text-red-500 text-sm"
                    >
                      {{ editForm.errors.title }}
                    </p>
                  </div>

                  <div class="grid gap-3">
                    <Label for="description">Description</Label>
                    <Input
                      id="description"
                      v-model="editForm.description"
                    />
                    <p
                      v-if="editForm.errors.description"
                      class="text-red-500 text-sm"
                    >
                      {{ editForm.errors.description }}
                    </p>
                  </div>

                  <div class="grid gap-3">
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
                  </div>

                  <div class="grid gap-3">
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
                  </div>

                  <div class="grid gap-3">
                    <div>
                      <Label for="themes">Thèmes</Label>
                    </div>
                    <MultiSelect
                      v-model="editForm.themes_ids"
                      :options="themeOptions"
                      placeholder="Sélectionnez les thèmes"
                      search-placeholder="Rechercher un thème..."
                      empty-message="Aucun thème trouvé."
                    />
                  </div>

                  <div class="grid gap-3">
                    <div>
                      <Label for="icon">Icône</Label>
                      <span class="text-sm text-muted-foreground"> (taille max 500KB) </span>
                    </div>
                    <Input
                      id="icon"
                      type="file"
                      @change="(e: Event) => (editForm.icon = (e.target as HTMLInputElement).files?.[0] ?? null)"
                    />
                    <p
                      v-if="editForm.errors.icon"
                      class="text-red-500 text-sm"
                    >
                      {{ editForm.errors.icon }}
                    </p>
                  </div>
                </CardContent>
              </Card>
            </TabsContent>
            <TabsContent
              value="q&a"
              class="overflow-y-auto m-0"
            >
              <Card class="bg-transparent border-none !shadow-none">
                <CardHeader>
                  <CardTitle>Questions et Réponses</CardTitle>
                  <CardDescription> Remplissez les 20 questions et réponses du quiz. </CardDescription>
                </CardHeader>
                <CardContent class="grid gap-6">
                  <div
                    class="grid gap-3 border-b pb-6 relative last:border-0 last:pb-0"
                    v-for="(question, qIndex) in editForm.questions"
                    :key="qIndex"
                  >
                    <div class="flex items-center justify-between">
                      <Label :for="`question-${qIndex}`">Question {{ qIndex + 1 }}</Label>
                      <div class="flex items-center gap-2">
                        <div class="flex gap-3">
                          <Label
                            :for="`question-${qIndex}-timer`"
                            class="text-muted-foreground"
                            >Durée (s)</Label
                          >
                          <Input
                            :id="`question-${qIndex}-timer`"
                            v-model="question.timer"
                            placeholder="Entrez la durée en secondes..."
                            type="number"
                            :min="quizConfig.MIN_QUESTION_TIMER_S"
                            :max="quizConfig.MAX_QUESTION_TIMER_S"
                            class="max-w-[70px]"
                          />
                        </div>
                        <span class="text-sm text-muted-foreground">Réponse multiple</span>
                        <Switch
                          class="cursor-pointer"
                          v-model="question.is_multiple"
                        />
                      </div>
                    </div>

                    <Input
                      :id="`question-${qIndex}`"
                      v-model="question.content"
                      placeholder="Entrez la question..."
                    />
                    <p
                      v-if="editForm.errors[`questions.${qIndex}.content`]"
                      class="text-red-500 text-sm"
                    >
                      {{ editForm.errors[`questions.${qIndex}.content`] }}
                    </p>

                    <p
                      v-if="editForm.errors[`questions.${qIndex}.timer`]"
                      class="text-red-500 text-sm"
                    >
                      {{ editForm.errors[`questions.${qIndex}.timer`] }}
                    </p>
                    <div class="grid gap-2">
                      <span class="text-sm font-medium">Réponses (sélectionnez la bonne réponse)</span>
                      <RadioGroup
                        v-if="!question.is_multiple"
                        :model-value="String(question.answers.findIndex((a) => a.is_correct))"
                        @update:model-value="
                          (val: string) => {
                            question.answers.forEach((a, i) => (a.is_correct = i === Number(val)));
                          }
                        "
                      >
                        <div
                          v-for="(answer, aIndex) in question.answers"
                          :key="aIndex"
                          class="flex items-center gap-3"
                        >
                          <RadioGroupItem
                            :id="`q${qIndex}-a${aIndex}`"
                            :value="aIndex.toString()"
                            class=""
                          />
                          <Input
                            v-model="answer.content"
                            :placeholder="`Réponse ${aIndex + 1}`"
                            class="flex-1"
                            :class="{
                              'border-red-500': editForm.errors[`questions.${qIndex}.answers.${aIndex}.content`],
                            }"
                          />
                        </div>
                      </RadioGroup>
                      <div
                        v-else
                        class="flex items-center gap-3"
                        v-for="(answer, aIndex) in question.answers"
                      >
                        <Checkbox
                          :key="aIndex"
                          :id="`q${qIndex}-a${aIndex}`"
                          v-model="answer.is_correct"
                        />
                        <Input
                          v-model="answer.content"
                          :placeholder="`Réponse ${aIndex + 1}`"
                          class="flex-1"
                        />
                      </div>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </TabsContent>
            <DialogFooter class="mt-2 border-t p-2">
              <div class="flex w-full items-center justify-between">
                <div class="flex items-center gap-2">
                  <Switch
                    v-model="editForm.is_published"
                    class="cursor-pointer"
                  />
                  <span>Publié</span>
                </div>

                <div class="flex gap-2">
                  <DialogClose as-child>
                    <Button
                      variant="outline"
                      @click="model = false"
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
                      class="h-4 w-4 animate-spin"
                    />
                    Modifier le quiz
                  </Button>
                </div>
              </div>
            </DialogFooter>
          </div>
        </Tabs>
      </form>
    </DialogContent>
  </Dialog>
</template>
