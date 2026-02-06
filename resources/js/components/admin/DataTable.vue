<script setup lang="ts" generic="TData, TValue">
import Button from '@/components/ui/button/Button.vue';
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuCheckboxItem from '@/components/ui/dropdown-menu/DropdownMenuCheckboxItem.vue';
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import Input from '@/components/ui/input/Input.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import type { ColumnDef } from '@tanstack/vue-table';
import {
  FilterFn,
  FlexRender,
  getCoreRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  useVueTable,
} from '@tanstack/vue-table';
import { ChevronDown, Search } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
  columns: ColumnDef<TData, TValue>[];
  data: TData[];
  meta?: Record<string, unknown>;
}>();

const searchText = ref('');

const globalFilterFn: FilterFn<TData> = (row, _columnId, filterValue) => {
  const search = filterValue.toLowerCase();

  const searchInValue = (value: unknown): boolean => {
    if (value == null) return false;
    if (typeof value === 'string') return value.toLowerCase().includes(search);
    if (typeof value === 'number') return value.toString().includes(search);
    if (typeof value === 'boolean') return false;
    if (Array.isArray(value)) return value.some(searchInValue);
    if (typeof value === 'object') return Object.values(value).some(searchInValue);
    return false;
  };

  return searchInValue(row.original);
};

const table = useVueTable({
  get data() {
    return props.data;
  },
  get columns() {
    return props.columns;
  },
  getCoreRowModel: getCoreRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
  globalFilterFn,
  getRowId: (row: TData) => {
    return (row as { id?: string }).id ?? String(props.data.indexOf(row));
  },
  state: {
    get globalFilter() {
      return searchText.value;
    },
  },
  meta: props.meta,
});
</script>

<template>
  <div class="rounded-md flex flex-col gap-4">
    <div class="flex justify-between items-center">
      <div class="relative">
        <Input
          v-model="searchText"
          placeholder="rechercher... "
          class="max-w-[250px] pl-8 text-xs uppercase tracking-wider"
        />
        <Search
          class="absolute left-2 top-1/2 transform -translate-y-1/2"
          :size="16"
        />
      </div>

      <DropdownMenu>
        <DropdownMenuTrigger as-child>
          <Button
            variant="outline"
            class="ml-auto"
          >
            Afficher
            <ChevronDown class="w-4 h-4 ml-2" />
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
          <DropdownMenuCheckboxItem
            v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
            :key="column.id"
            :modelValue="column.getIsVisible()"
            @update:modelValue="
              (value) => {
                column.toggleVisibility(!!value);
              }
            "
          >
            {{ column.columnDef.meta?.title ?? column.id }}
          </DropdownMenuCheckboxItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </div>

    <Table>
      <TableHeader class="bg-secondary2 dark:bg-background">
        <TableRow
          v-for="headerGroup in table.getHeaderGroups()"
          :key="headerGroup.id"
        >
          <TableHead
            v-for="header in headerGroup.headers"
            :key="header.id"
          >
            <FlexRender
              v-if="!header.isPlaceholder"
              :render="header.column.columnDef.header"
              :props="header.getContext()"
            />
          </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <template v-if="table.getRowModel().rows?.length">
          <TableRow
            v-for="row in table.getRowModel().rows"
            :key="row.id"
            :data-state="row.getIsSelected() ? 'selected' : undefined"
          >
            <TableCell
              v-for="cell in row.getVisibleCells()"
              :key="cell.id"
            >
              <FlexRender
                :render="cell.column.columnDef.cell"
                :props="cell.getContext()"
              />
            </TableCell>
          </TableRow>
        </template>
        <template v-else>
          <TableRow>
            <TableCell
              :colspan="columns.length"
              class="h-24 text-center"
            >
              Pas de résultats.
            </TableCell>
          </TableRow>
        </template>
      </TableBody>
    </Table>

    <div class="flex justify-between items-center">
      <span class="rounded px-3 py-1 text-xs uppercase font-bold bg-background border tracking-wider"
        >{{ table.getRowCount() }} résultats</span
      >
      <div class="flex items-center py-4 space-x-2">
        <Button
          variant="outline"
          size="sm"
          :disabled="!table.getCanPreviousPage()"
          @click="table.previousPage()"
        >
          Précédent
        </Button>
        <Button
          variant="outline"
          size="sm"
          :disabled="!table.getCanNextPage()"
          @click="table.nextPage()"
        >
          Suivant
        </Button>
      </div>
    </div>
  </div>
</template>
