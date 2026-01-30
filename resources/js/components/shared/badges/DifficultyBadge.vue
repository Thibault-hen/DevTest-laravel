<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { useAppearance } from '@/composables/useAppearance';
import { COLORS } from '@/constants/colors';
import { DifficultyData } from '@/types/generated';
import { Gauge } from 'lucide-vue-next';

const props = defineProps<{ difficulty: DifficultyData | null }>();

const { isDark } = useAppearance();
</script>

<template>
  <Badge
    class="font-bold flex max-w-fit items-center gap-2 rounded-md border p-1 px-2 text-xs text-white shadow drop-shadow"
    :style="{
      backgroundColor: isDark()
        ? `${props.difficulty?.color ?? COLORS.DEFAULT}10`
        : (props.difficulty?.color ?? COLORS.DEFAULT),
      borderColor: props.difficulty?.color ?? COLORS.DEFAULT,
      color: isDark() ? (props.difficulty?.color ?? COLORS.DEFAULT) : '',
    }"
    ><Gauge :size="16" />{{ props.difficulty?.level ?? 'Non définie' }}
  </Badge>
</template>
