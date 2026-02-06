import QuizzesCountBadge from '@/components/shared/badges/QuizzesCountBadge.vue';
import ThemeBadge from '@/components/shared/badges/ThemeBadge.vue';
import { ThemeData } from '@/types/generated';
import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import ThemesActions from './ThemeActions.vue';

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
    accessorKey: 'updated_at',
    header: () => h('div', 'Mis à jour le'),
    meta: { title: 'Mis à jour le' },
    cell: ({ row }) => {
      return h('div', { class: 'font-medium' }, row.original.updated_at);
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
