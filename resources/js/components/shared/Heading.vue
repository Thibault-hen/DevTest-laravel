<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
}

defineProps<Props>();
</script>

<template>
    <div class="group relative mb-8 space-y-2">
        <h2 class="text-2xl font-bold tracking-tight">
            {{ title }}
        </h2>

        <p
            v-if="description"
            class="max-w-2xl animate-in text-sm leading-relaxed text-gray-600 duration-500 fade-in slide-in-from-left-2 dark:text-gray-400"
        >
            {{ description }}
        </p>

        <div
            class="relative mt-4 h-px w-full overflow-hidden rounded-full bg-gradient-to-r from-transparent via-gray-400 to-transparent dark:via-primary/30"
        >
            <div
                class="absolute inset-0 translate-x-[-100%] bg-gradient-to-r from-transparent via-primary to-transparent opacity-0 transition-all duration-700 group-hover:translate-x-[100%] group-hover:opacity-100"
            ></div>
        </div>
    </div>
</template>
