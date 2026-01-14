<script lang="ts" setup>
import { Switch } from '@/components/ui/switch';
import { useAppearance } from '@/composables/useAppearance';
import { Moon, Sun } from 'lucide-vue-next';
import { ref } from 'vue';

const { toggleTheme, getStoredAppearance } = useAppearance();

const isDark = ref(getStoredAppearance() === 'dark');

const handleToggle = () => {
  isDark.value = !isDark.value;
  toggleTheme();
};
</script>

<template>
  <Switch
    :model-value="isDark"
    @update:model-value="handleToggle"
    class="cursor-pointer"
  >
    <template #thumb>
      <Sun
        v-if="!isDark"
        class="mt-0.5 ml-0.5 size-3"
        stroke-width="1.5"
      />
      <Moon
        v-else
        class="mt-0.5 ml-0.5 size-3"
        stroke-width="1.5"
      />
    </template>
  </Switch>
</template>
