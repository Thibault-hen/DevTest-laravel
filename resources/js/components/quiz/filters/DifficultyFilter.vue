<script setup lang="ts">
import HeadingSmall from '@/components/shared/HeadingSmall.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import { DifficultyData } from '@/types/generated';
import { ref } from 'vue';

const props = defineProps<{
    difficulties: DifficultyData[];
}>();

const emit = defineEmits<{
    (e: 'update:difficulty', value: Array<string>): void;
}>();

const selectedDifficulty = ref<string[]>([]);

const toggleDifficulty = (level: string) => {
    selectedDifficulty.value.includes(level)
        ? (selectedDifficulty.value = selectedDifficulty.value.filter((d) => d !== level))
        : selectedDifficulty.value.push(level);
    emit('update:difficulty', selectedDifficulty.value);
};
</script>

<template>
    <div>
        <HeadingSmall title="Difficulté" description="Filtrer par difficulté" />
        <div class="mt-4 flex flex-col gap-2">
            <Button
                v-for="difficulty in props.difficulties"
                :key="difficulty.level"
                variant="secondary"
                class="cursor-pointer border font-bold"
                :class="{
                    'opacity-100': selectedDifficulty.includes(difficulty.level),
                }"
                :style="{
                    backgroundColor: selectedDifficulty.includes(difficulty.level) ? difficulty.color : `${difficulty.color}30`,
                    borderColor: difficulty.color,
                    color: selectedDifficulty.includes(difficulty.level) ? 'white' : difficulty.color,
                }"
                @click="toggleDifficulty(difficulty.level)"
            >
                {{ difficulty.level }}
                <Badge class="ml-auto border border-border bg-background text-black dark:text-white">{{ difficulty.quizzes_count }}</Badge>
            </Button>
        </div>
    </div>
</template>
