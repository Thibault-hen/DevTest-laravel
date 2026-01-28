import CategoryBadge from '@/components/quiz/badges/CategoryBadge.vue';
import QuizzesCountBadge from '@/components/quiz/badges/QuizzesCountBadge.vue';
import { CategoryData } from '@/types/generated';
import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import CategoryActions from './CategoryActions.vue';

export const categoriesColumn: ColumnDef<CategoryData>[] = [
  {
    accessorKey: 'id',
    header: () => h('div', '#'),
    meta: { title: 'id' },
    cell: ({ row }) => {
      return h('div', { class: 'font-bold' }, row.index + 1);
    },
  },
  {
    accessorKey: 'title',
    header: () => h('div', 'Titre'),
    meta: { title: 'Titre' },
    cell: ({ row }) => {
      return h(CategoryBadge, { category: row.original });
    },
  },
  {
    accessorKey: 'quizzes_count',
    header: () => h('div', 'Quiz associés'),
    meta: { title: 'Quiz associés' },
    cell: ({ row }) => {
      return h(QuizzesCountBadge, { count: row.original.quizzes_count ?? 0 });
    },
  },
  {
    accessorKey: 'created_at',
    header: () => h('div', 'Créé le'),
    meta: { title: 'Créé le' },
    cell: ({ row }) => {
      return h('div', { class: 'font-bold' }, row.original.created_at);
    },
  },
  {
    id: 'actions',
    header: () => h('div', { class: 'text-right' }, 'Actions'),
    meta: { title: 'Actions' },
    cell: ({ row, table }) => {
      const category = row.original;
      const meta = table.options.meta as {
        onOpenDelete?: (category: CategoryData) => void;
        onOpenEdit?: (category: CategoryData) => void;
      };
      return h(
        'div',
        { class: 'flex justify-end' },
        h(CategoryActions, { category: category, onOpenDelete: meta?.onOpenDelete, onOpenEdit: meta?.onOpenEdit }),
      );
    },
  },
];
