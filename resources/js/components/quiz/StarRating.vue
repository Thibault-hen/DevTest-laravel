<script setup lang="ts">
import { Star, StarHalf } from 'lucide-vue-next';
const props = defineProps<{
    rating: number;
}>();

const MAX_STARS: number = 5;

const fullStars = Math.floor(props.rating);
const hasHalfStar = props.rating % 1 >= 0.1;
const emptyStars = MAX_STARS - Math.ceil(props.rating);
</script>

<template>
    <div class="flex items-center gap-0.5">
        <Star v-for="star in fullStars" :key="`full-${star}`" :size="16" fill="#009966" stroke-width="0.5" />

        <div class="relative" v-if="hasHalfStar">
            <StarHalf :size="16" fill="#009966" stroke-width="0.5" />
            <Star class="absolute top-0 left-0" :size="16" stroke-width="0.5" />
        </div>

        <Star v-for="star in emptyStars" :key="`full-${star}`" :size="16" stroke-width="0.5" />

        <span class="ml-2 text-sm">{{ props.rating.toFixed(1) }}</span>
    </div>
</template>
