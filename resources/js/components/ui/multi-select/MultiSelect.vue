<script setup lang="ts" generic="T extends { id: string; label: string }">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList } from '@/components/ui/command';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { Check, ChevronsUpDown, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = withDefaults(
  defineProps<{
    options: T[];
    placeholder?: string;
    searchPlaceholder?: string;
    emptyMessage?: string;
    class?: string;
    maxDisplayedItems?: number;
  }>(),
  {
    placeholder: 'Sélectionnez...',
    searchPlaceholder: 'Rechercher...',
    emptyMessage: 'Aucun résultat.',
    maxDisplayedItems: 3,
  },
);

const modelValue = defineModel<string[]>({ default: () => [] });

const open = ref(false);

const selectedItems = computed(() => {
  return props.options.filter((option) => modelValue.value.includes(option.id));
});

const toggleOption = (optionId: string): void => {
  const index = modelValue.value.indexOf(optionId);
  if (index === -1) {
    modelValue.value = [...modelValue.value, optionId];
  } else {
    modelValue.value = modelValue.value.filter((id) => id !== optionId);
  }
};

const removeOption = (optionId: string, event: Event): void => {
  event.stopPropagation();
  modelValue.value = modelValue.value.filter((id) => id !== optionId);
};

const clearAll = (event: Event): void => {
  event.stopPropagation();
  modelValue.value = [];
};
</script>

<template>
  <Popover v-model:open="open">
    <PopoverTrigger as-child>
      <Button
        variant="outline"
        role="combobox"
        :aria-expanded="open"
        :class="
          cn(
            'h-auto min-h-10 w-full justify-between dark:bg-input/30 hover:bg-transparent dark:hover:bg-input/30',
            props.class,
          )
        "
      >
        <div class="flex flex-1 flex-wrap gap-1">
          <template v-if="selectedItems.length === 0">
            <span class="text-muted-foreground font-normal">{{ placeholder }}</span>
          </template>
          <template v-else-if="selectedItems.length <= maxDisplayedItems">
            <Badge
              v-for="item in selectedItems"
              :key="item.id"
              variant="secondary"
              class="mr-1 flex items-center gap-1"
            >
              {{ item.label }}
              <X
                class="h-3 w-3 cursor-pointer hover:text-destructive"
                @click="removeOption(item.id, $event)"
              />
            </Badge>
          </template>
          <template v-else>
            <Badge
              v-for="item in selectedItems.slice(0, maxDisplayedItems)"
              :key="item.id"
              variant="secondary"
              class="mr-1 flex items-center gap-1"
            >
              {{ item.label }}
              <X
                class="h-3 w-3 cursor-pointer hover:text-destructive"
                @click="removeOption(item.id, $event)"
              />
            </Badge>
            <Badge variant="secondary"> +{{ selectedItems.length - maxDisplayedItems }} </Badge>
          </template>
        </div>
        <div class="flex items-center gap-1">
          <X
            v-if="selectedItems.length > 0"
            class="h-4 w-4 shrink-0 opacity-50 hover:opacity-100"
            @click="clearAll"
          />
          <ChevronsUpDown class="h-4 w-4 shrink-0 opacity-50" />
        </div>
      </Button>
    </PopoverTrigger>
    <PopoverContent
      class="w-[--reka-popover-trigger-width] p-0"
      align="start"
    >
      <Command multiple>
        <CommandInput :placeholder="searchPlaceholder" />
        <CommandList>
          <CommandEmpty>{{ emptyMessage }}</CommandEmpty>
          <CommandGroup>
            <CommandItem
              v-for="option in options"
              :key="option.id"
              :value="option.label"
              @select="toggleOption(option.id)"
            >
              <div
                :class="
                  cn(
                    'mr-2 flex h-4 w-4 items-center justify-center rounded-sm border border-primary',
                    modelValue.includes(option.id)
                      ? 'bg-primary text-primary-foreground'
                      : 'opacity-50 [&_svg]:invisible',
                  )
                "
              >
                <Check class="h-3 w-3" />
              </div>
              <span>{{ option.label }}</span>
            </CommandItem>
          </CommandGroup>
        </CommandList>
      </Command>
    </PopoverContent>
  </Popover>
</template>
