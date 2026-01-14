<script setup lang="ts">
import DifficultyBadge from '@/components/quiz/badges/DifficultyBadge.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { Dialog, DialogClose, DialogContent, DialogFooter } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
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
import type { CategoryData, DifficultyData, ThemeData } from '@/types/generated';
import { Info, LoaderCircle } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const closeDialog = (): void => {
  open.value = false;
};

const props = defineProps<{
  modelValue: boolean;
  themes: ThemeData[];
  categories: CategoryData[];
  difficulties: DifficultyData[];
}>();

const { createQuiz, form, isQuizInfoFilled, themeOptions } = useQuizAdminForm(closeDialog, props.themes);

const open = ref(props.modelValue);

const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void;
}>();

watch(
  () => props.modelValue,
  (val) => (open.value = val),
);
watch(open, (val) => emit('update:modelValue', val));
</script>

<template>
  <Dialog v-model:open="open">
    <DialogContent class="sm:max-w-[900px] max-h-[90vh] flex flex-col">
      <form
        @submit.prevent="createQuiz"
        class="flex w-full flex-col gap-6 overflow-hidden"
      >
        <Tabs
          default-value="account"
          orientation="vertical"
          class="flex w-full gap-4 overflow-hidden"
        >
          <TabsList class="flex flex-col justify-start bg-transparent items-start">
            <div class="flex flex-col border-b p-2 mb-4 w-full gap-4">
              <span class="text-lg font-semibold dark:text-white">Ajouter un nouveau quiz</span>
              <span class="text-sm text-muted-foreground">
                Remplissez les informations du quiz ainsi que les questions et réponses.
              </span>
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
              :disabled="!isQuizInfoFilled"
            >
              <div class="flex flex-col items-start w-full">
                <div class="flex items-center justify-between w-full">
                  <span>Questions & Réponses</span>
                  <Info
                    v-if="!isQuizInfoFilled"
                    class="text-red-400 bg-red-500/20 rounded-full p-0.5"
                  />
                </div>
                <span
                  v-if="!isQuizInfoFilled"
                  class="text-red-200 mt-1 text-xs normal-case rounded"
                >
                  Veuillez remplir toutes les informations du quiz.
                </span>
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
                      v-model="form.title"
                    />
                    <p
                      v-if="form.errors.title"
                      class="text-red-500 text-sm"
                    >
                      {{ form.errors.title }}
                    </p>
                  </div>

                  <div class="grid gap-3">
                    <Label for="description">Description</Label>
                    <Input
                      id="description"
                      v-model="form.description"
                    />
                    <p
                      v-if="form.errors.description"
                      class="text-red-500 text-sm"
                    >
                      {{ form.errors.description }}
                    </p>
                  </div>

                  <div class="grid gap-3">
                    <Label for="duration">Durée (minutes)</Label>
                    <Input
                      id="duration"
                      v-model="form.duration"
                      type="number"
                      min="1"
                    />
                    <p
                      v-if="form.errors.duration"
                      class="text-red-500 text-sm"
                    >
                      {{ form.errors.duration }}
                    </p>
                  </div>

                  <div class="grid gap-3">
                    <Label for="difficulty">Difficulté</Label>
                    <Select
                      id="difficulty"
                      v-model="form.difficulty_id"
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
                      v-if="form.errors.difficulty_id"
                      class="text-red-500 text-sm"
                    >
                      {{ form.errors.difficulty_id }}
                    </p>
                  </div>

                  <div class="grid gap-3">
                    <Label for="category">Catégorie</Label>
                    <Select
                      id="category"
                      v-model="form.category_id"
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
                      v-if="form.errors.category_id"
                      class="text-red-500 text-sm"
                    >
                      {{ form.errors.category_id }}
                    </p>
                  </div>

                  <div class="grid gap-3">
                    <div>
                      <Label for="themes">Thèmes</Label>
                    </div>
                    <MultiSelect
                      v-model="form.themes_ids"
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
                      @change="(e: Event) => (form.icon = (e.target as HTMLInputElement).files?.[0] ?? null)"
                    />
                    <p
                      v-if="form.errors.icon"
                      class="text-red-500 text-sm"
                    >
                      {{ form.errors.icon }}
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
                    v-for="(question, qIndex) in form.questions"
                    :key="qIndex"
                  >
                    <Label :for="`question-${qIndex}`">Question {{ qIndex + 1 }}</Label>
                    <div class="absolute right-0 -top-1 flex items-center gap-2">
                      <span class="text-sm text-muted-foreground">Réponse multiple</span>
                      <Switch
                        class="cursor-pointer"
                        v-model="question.is_multiple"
                      />
                    </div>
                    <Input
                      :id="`question-${qIndex}`"
                      v-model="question.content"
                      placeholder="Entrez la question..."
                    />
                    <p
                      v-if="form.errors[`questions.${qIndex}.content`]"
                      class="text-red-500 text-sm"
                    >
                      {{ form.errors[`questions.${qIndex}.content`] }}
                    </p>
                    <div class="grid gap-2">
                      <span class="text-sm font-medium">Réponses (sélectionnez la bonne réponse)</span>
                      <p
                        v-if="form.errors[`questions.${qIndex}.answers`]"
                        class="text-red-500 text-sm"
                      >
                        {{ form.errors[`questions.${qIndex}.answers`] }}
                      </p>
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
                            :class="{ 'border-red-500': form.errors[`questions.${qIndex}.answers.${aIndex}.content`] }"
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
                    v-model="form.is_published"
                    class="cursor-pointer"
                  />
                  <span>Publié</span>
                </div>

                <div class="flex gap-2">
                  <DialogClose as-child>
                    <Button
                      variant="outline"
                      @click="closeDialog"
                    >
                      Annuler
                    </Button>
                  </DialogClose>

                  <Button
                    type="submit"
                    :disabled="form.processing"
                  >
                    <LoaderCircle
                      v-if="form.processing"
                      class="h-4 w-4 animate-spin"
                    />
                    Créer le quiz
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
