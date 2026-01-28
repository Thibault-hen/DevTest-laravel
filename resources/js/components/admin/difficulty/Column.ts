import DifficultyBadge from '@/components/quiz/badges/DifficultyBadge.vue';
import QuizzesCountBadge from '@/components/quiz/badges/QuizzesCountBadge.vue';
import { DifficultyData } from '@/types/generated';
import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import DifficultyActions from './DifficultyActions.vue';

export const difficultyColumns: ColumnDef<DifficultyData>[] = [
  {
    accessorKey: 'id',
    header: () => h('div', '#'),
    meta: { title: 'id' },
    cell: ({ row }) => {
      return h('div', { class: 'font-bold' }, row.index + 1);
    },
  },
  {
    accessorKey: 'level',
    header: () => h('div', 'Difficulté'),
    meta: { title: 'Difficulté' },
    cell: ({ row }) => {
      return h(DifficultyBadge, { class: 'font-medium', difficulty: row.original }, row.original.level);
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
      return h('div', { class: 'font-medium' }, row.original.created_at);
    },
  },
  {
    id: 'actions',
    header: () => h('div', { class: 'text-right' }, 'Actions'),
    meta: { title: 'Actions' },
    cell: ({ row, table }) => {
      const difficulty = row.original;
      const meta = table.options.meta as {
        onOpenDelete?: (difficulty: DifficultyData) => void;
        onOpenEdit?: (difficulty: DifficultyData) => void;
      };
      return h(
        'div',
        { class: 'flex justify-end' },
        h(DifficultyActions, {
          difficulty: difficulty,
          onOpenDelete: meta?.onOpenDelete,
          onOpenEdit: meta?.onOpenEdit,
        }),
      );
    },
  },
];
