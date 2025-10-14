<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import type { HomepageCounter } from '@/types';
import NumberFlow, { continuous } from '@number-flow/vue';
import { onMounted, ref } from 'vue';

const animatedCount = ref(0);

onMounted(() => {
    setTimeout(() => {
        animatedCount.value = props.count;
    }, 600);
});
const props = defineProps<HomepageCounter>();
</script>

<template>
    <Card
        class="group relative w-full overflow-hidden rounded-[8px] border-l-4 border-l-primary bg-gradient-to-br from-card to-card/50 p-6 transition-all duration-300 sm:max-w-[280px]"
    >
        <!-- Icon avec effet parallax -->
        <div class="absolute -top-4 -right-4 opacity-10 transition-all duration-300">
            <component :is="props.icon" v-if="props.icon" :stroke-width="1" class="h-16 w-16 text-primary md:h-20 md:w-20 xl:h-24 xl:w-24" />
        </div>

        <!-- Contenu -->
        <div class="relative z-10 flex flex-col gap-3">
            <!-- Nombre avec animation -->
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-bold tracking-tight text-foreground">
                    <NumberFlow
                        class="text-xl md:text-4xl"
                        :value="animatedCount"
                        :plugins="[continuous]"
                        :spin-timing="{
                            duration: 1200,
                        }"
                    />
                </span>
                <span class="text-xs font-medium tracking-wider text-muted-foreground uppercase">{{ props.label2 }}</span>
            </div>

            <!-- Label avec icône inline -->
            <div class="flex items-center gap-2">
                <component :is="props.icon" v-if="props.icon" :stroke-width="2" class="h-4 w-4 text-primary" />
                <p class="truncate text-xs font-medium text-muted-foreground lg:text-sm">
                    {{ props.label }}
                </p>
            </div>
        </div>
    </Card>
</template>
