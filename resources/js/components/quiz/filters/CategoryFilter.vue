<script setup lang="ts">
import HeadingSmall from '@/components/shared/HeadingSmall.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import Label from '@/components/ui/label/Label.vue';
import { CategoryData } from '@/types/generated';
import { Minus, Plus, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<{
  categories: CategoryData[];
}>();

const emit = defineEmits<{
  (e: 'update:category', value: Array<string>): void;
}>();

const isCollapsed = ref(true);
const selectedCategories = ref<string[]>([]);

const collapsedCategories = computed((): Array<CategoryData | null> => {
  return isCollapsed.value ? props.categories?.slice(0, 3) || [] : props.categories || [];
});

const isCategorySelected = (category: string | null | undefined): boolean =>
  category ? selectedCategories.value.includes(category) : false;

const toggleCollapsed = (): void => {
  isCollapsed.value = !isCollapsed.value;
};

const toggleCategory = (category: string) => {
  if (!selectedCategories.value.includes(category)) {
    selectedCategories.value.push(category);
  } else {
    const index = selectedCategories.value.indexOf(category);
    if (index > -1) {
      selectedCategories.value.splice(index, 1);
    }
  }
  emit('update:category', selectedCategories.value);
};

const resetCategories = (): void => {
  selectedCategories.value = [];
  emit('update:category', selectedCategories.value);
};
</script>

<template>
  <div>
    <HeadingSmall
      title="Catégorie"
      description="Filtrer par catégorie"
    >
      <template #label>
        <Badge
          v-if="selectedCategories.length > 0"
          class="border border-border bg-background text-black dark:text-white"
        >
          {{ selectedCategories.length }}
          <span
            @click="resetCategories"
            class="cursor-pointer rounded-lg p-0.5 hover:bg-primary/50"
            ><X :size="14"
          /></span>
        </Badge>
      </template>
    </HeadingSmall>
    <div class="mt-4 flex flex-col gap-2">
      <div
        v-for="category in collapsedCategories"
        :key="category?.id"
        class="flex items-center space-x-3"
      >
        <Checkbox
          v-if="category?.name"
          :id="category.id"
          :model-value="isCategorySelected(category.name!)"
          @update:model-value="() => toggleCategory(category.name)"
        />
        <Label
          :for="category?.id"
          class="flex cursor-pointer items-center gap-2"
        >
          {{ category?.name }}
          <Badge class="border border-border bg-background text-black dark:text-white">
            {{ category?.quizzes_count }}
          </Badge>
        </Label>
      </div>
      <Button
        class="mx-auto max-w-fit text-xs"
        variant="default"
        @click="toggleCollapsed"
        >{{ isCollapsed ? 'Voir plus' : 'Voir moins' }}
        <Plus v-if="isCollapsed" />
        <Minus v-else />
      </Button>
    </div>
  </div>
</template>
