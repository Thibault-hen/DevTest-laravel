<script setup lang="ts">
import HeadingSmall from '@/components/shared/HeadingSmall.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import Label from '@/components/ui/label/Label.vue';
import { ThemeData } from '@/types/generated';
import { Minus, Plus, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<{
  themes: ThemeData[];
}>();

const emit = defineEmits<{
  (e: 'update:theme', value: Array<string>): void;
}>();

const isCollapsed = ref(true);
const selectedThemes = ref<string[]>([]);

const collapsedThemes = computed((): Array<ThemeData | null> => {
  return isCollapsed.value ? props.themes?.slice(0, 3) || [] : props.themes || [];
});

const isThemeSelected = (theme: string | null | undefined): boolean =>
  theme ? selectedThemes.value.includes(theme) : false;

const toggleCollapsed = (): void => {
  isCollapsed.value = !isCollapsed.value;
};

const toggleTheme = (theme: string) => {
  if (!selectedThemes.value.includes(theme)) {
    selectedThemes.value.push(theme);
  } else {
    const index = selectedThemes.value.indexOf(theme);
    if (index > -1) {
      selectedThemes.value.splice(index, 1);
    }
  }
  emit('update:theme', selectedThemes.value);
};

const resetThemes = (): void => {
  selectedThemes.value = [];
  emit('update:theme', selectedThemes.value);
};
</script>

<template>
  <div>
    <div>
      <HeadingSmall
        title="Thème"
        description="Filtrer par thème"
      >
        <template #label>
          <Badge
            v-if="selectedThemes.length > 0"
            class="border border-border bg-background text-black dark:text-white"
          >
            {{ selectedThemes.length }}
            <span
              @click="resetThemes"
              class="cursor-pointer rounded-lg p-0.5 hover:bg-primary/50"
              ><X :size="14"
            /></span>
          </Badge>
        </template>
      </HeadingSmall>
    </div>
    <div class="mt-4 flex flex-col gap-2">
      <div
        v-for="theme in collapsedThemes"
        :key="theme?.id"
        class="flex items-center space-x-3"
      >
        <Checkbox
          v-if="theme?.title"
          :id="theme.id"
          :model-value="isThemeSelected(theme.title!)"
          @update:model-value="() => toggleTheme(theme.title)"
        />
        <Label
          :for="theme?.id"
          class="flex cursor-pointer items-center gap-2"
        >
          {{ theme?.title }}
          <Badge class="border border-border bg-background text-black dark:text-white">
            {{ theme?.quizzes_count }}
          </Badge>
        </Label>
      </div>
      <Button
        class="mx-auto max-w-fit text-xs"
        variant="default"
        @click="toggleCollapsed"
        >{{ isCollapsed ? 'Voir plus' : 'Voir moins' }} <Plus v-if="isCollapsed" /> <Minus v-else
      /></Button>
    </div>
  </div>
</template>
