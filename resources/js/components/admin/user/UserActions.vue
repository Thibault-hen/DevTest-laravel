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
import { UserData } from '@/types/generated';
import { MoreHorizontal, Pencil, Trash2 } from 'lucide-vue-next';

const props = defineProps<{
  user: UserData;
  onOpenDelete?: (user: UserData) => void;
  onOpenEdit?: (user: UserData) => void;
}>();

const handleOpenDelete = (): void => {
  props.onOpenDelete?.(props.user);
};

const handleOpenEdit = (): void => {
  props.onOpenEdit?.(props.user);
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
      <DropdownMenuItem @click="handleOpenEdit">
        <Pencil class="mr-2 h-4 w-4" />
        Détails
      </DropdownMenuItem>
      <DropdownMenuItem @click="handleOpenDelete">
        <Trash2 class="mr-2 h-4 w-4" />
        Supprimer
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
