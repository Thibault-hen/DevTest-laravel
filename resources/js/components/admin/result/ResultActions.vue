<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { ResultData } from '@/types/generated';
import { Eye, MoreHorizontal, Trash2 } from 'lucide-vue-next';

const props = defineProps<{
  result: ResultData;
  onOpenDelete?: (result: ResultData) => void;
  onOpenView?: (result: ResultData) => void;
}>();

const handleOpenDelete = (): void => {
  props.onOpenDelete?.(props.result);
};

const handleOpenView = (): void => {
  props.onOpenView?.(props.result);
};
</script>
<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button
        variant="ghost"
        class="w-8 h-8 p-0"
      >
        <span class="sr-only">Ouvrir menu actions</span>
        <MoreHorizontal class="w-4 h-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuLabel>Actions</DropdownMenuLabel>
      <DropdownMenuSeparator />
      <DropdownMenuItem @click="handleOpenView">
        <Eye class="mr-2 h-4 w-4" />
        Détails
      </DropdownMenuItem>
      <DropdownMenuItem @click="handleOpenDelete">
        <Trash2 class="mr-2 h-4 w-4" />
        Supprimer
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
