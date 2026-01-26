import QuizActions from '@/components/admin/quiz/QuizActions.vue';
import CategoryBadge from '@/components/quiz/badges/CategoryBadge.vue';
import DifficultyBadge from '@/components/quiz/badges/DifficultyBadge.vue';
import { QuizData } from '@/types/generated';
import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import PublishSwitch from './PublishSwitch.vue';

export const quizColumns: ColumnDef<QuizData>[] = [
  {
    accessorKey: 'title',
    header: () => h('div', 'Titre'),
    meta: { title: 'Titre' },
    cell: ({ row }) => {
      return h('div', { class: 'font-medium' }, row.original.title);
    },
  },
  {
    accessorKey: 'category',
    header: () => h('div', 'Catégorie'),
    meta: { title: 'Catégorie' },
    cell: ({ row }) => {
      return h(CategoryBadge, { category: row.original.category });
    },
  },
  {
    accessorKey: 'difficulty',
    header: () => h('div', 'Difficulté'),
    meta: { title: 'Difficulté' },
    cell: ({ row }) => {
      return h(DifficultyBadge, {
        difficulty: row.original.difficulty,
      });
    },
  },
  {
    id: 'rating',
    header: () => h('div', 'Note'),
    meta: { title: 'Note' },
    cell: ({ row }) => {
      return h('div', { class: 'text-gray-400 font-bold' }, row.original.average_rating?.toFixed(1) ?? 'N/A');
    },
  },
  {
    accessorKey: 'author',
    header: () => h('div', 'Auteur'),
    meta: { title: 'Auteur' },
    cell: ({ row }) => {
      return h('div', { class: 'font-medium' }, row.original.author?.name);
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
    accessorKey: 'is_published',
    header: () => h('div', { class: 'text-right' }, 'Publié'),
    meta: { title: 'Publié' },
    cell: ({ row }) => {
      return h(
        'div',
        { class: 'flex justify-end' },
        h(PublishSwitch, {
          key: row.original.id,
          quizId: row.original.id,
          initialValue: row.original.is_published,
        }),
      );
    },
  },
  {
    id: 'actions',
    header: () => h('div', { class: 'text-right' }, 'Actions'),
    meta: { title: 'Actions' },
    cell: ({ row, table }) => {
      const quiz = row.original;
      const meta = table.options.meta as {
        onOpenDelete?: (quiz: QuizData) => void;
        onOpenEdit?: (quiz: QuizData) => void;
      };
      return h(
        'div',
        { class: 'flex justify-end' },
        h(QuizActions, { quiz, onOpenDelete: meta?.onOpenDelete, onOpenEdit: meta?.onOpenEdit }),
      );
    },
  },
];
