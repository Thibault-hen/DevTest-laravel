<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import { ResultData } from '@/types/generated';
import ResultDetailsStats from './ResultDetailsStats.vue';
const props = defineProps<{
  resultDetail: ResultData;
}>();
</script>

<template>
  <Card class="overflow-hidden py-2 relative">
    <CardContent class="p-0">
      <div class="p-4 px-8 lg:px-12">
        <div class="flex-col md:flex-row flex items-start gap-4">
          <div
            v-if="resultDetail.quiz.image_url"
            class="flex-shrink-0 h-12 w-12 rounded-xl self-center"
          >
            <img
              :src="`/${resultDetail.quiz.image_url}`"
              :alt="`${resultDetail.quiz.title} Image`"
              class="h-full w-full"
            />
          </div>
          <span class="absolute top-0 right-0 p-1 bg-background rounded-bl-sm border text-sm font-bold">{{
            new Date(resultDetail.completed_at).toDateString()
          }}</span>
          <div class="flex-1 min-w-0">
            <h2 class="text-base lg:text-lg font-bold mb-2">
              {{ resultDetail.quiz.title }}
            </h2>
            <p class="text-xs lg:text-sm line-clamp-2">
              {{ resultDetail.quiz.description }}
            </p>
          </div>
        </div>
      </div>

      <div class="border-t px-4 lg:px-12 py-6 flex flex-col items-center">
        <ResultDetailsStats
          :result-detail="props.resultDetail"
          class="w-full"
        />

        <div class="mt-6 lg:mt-8">
          <Button class="w-full lg:w-auto lg:min-w-[200px]"> Retourner aux quiz </Button>
        </div>
      </div>
    </CardContent>
  </Card>
</template>
