import ThemeBadge from '@/components/quiz/badges/ThemeBadge.vue';
import { ThemeData } from '@/types/generated';
import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import ThemesActions from './ThemesActions.vue';
export const themesColumns: ColumnDef<ThemeData>[] = [
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
      return h(ThemeBadge, { theme: row.original });
    },
  },
  {
    accessorKey: 'quizzes_count',
    header: () => h('div', 'Quizzes associés'),
    meta: { title: 'Quizzes associés' },
    cell: ({ row }) => {
      return h(
        'div',
        {
          class:
            'bg-muted rounded-md min-w-[3rem] border justify-center inline-flex py-1 px-3 font-bold' +
            ((row.original.quizzes_count ?? 0 > 0) ? ' border-primary' : ''),
        },
        row.original.quizzes_count ?? 0,
      );
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
      const quiz = row.original;
      const meta = table.options.meta as {
        onOpenDelete?: (theme: ThemeData) => void;
        onOpenEdit?: (theme: ThemeData) => void;
      };
      return h(
        'div',
        { class: 'flex justify-end' },
        h(ThemesActions, { theme: quiz, onOpenDelete: meta?.onOpenDelete, onOpenEdit: meta?.onOpenEdit }),
      );
    },
  },
];
