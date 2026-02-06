import ResultScoreBadge from '@/components/quiz/result/ResultScoreBadge.vue';
import { convertMillisecondsToTimeFormat } from '@/constants/timeFormat';
import { ResultData } from '@/types/generated';
import { getQuizResultColorCount } from '@/utils/quizResultColorCount';
import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import ResultActions from './ResultActions.vue';

export const resultColumns: ColumnDef<ResultData>[] = [
  {
    accessorKey: 'id',
    header: () => h('div', '#'),
    meta: { title: 'id' },
    cell: ({ row }) => {
      return h('div', { class: 'font-bold' }, row.index + 1);
    },
  },
  {
    accessorKey: 'quiz',
    header: () => h('div', 'Quiz'),
    meta: { title: 'Quiz' },
    cell: ({ row }) => {
      return h('div', { class: 'font-medium' }, row.original.quiz?.title ?? 'Quiz supprimé');
    },
  },
  {
    accessorKey: 'user',
    header: () => h('div', 'Utilisateur'),
    meta: { title: 'Utilisateur' },
    cell: ({ row }) => {
      return h('div', { class: 'flex flex-col' }, [
        h('span', { class: 'font-medium' }, `${row.original.user?.name ?? 'Utilisateur supprimé'}`),
        h('span', { class: 'font-bold text-xs' }, `${row.original.user?.email ?? ''}`),
      ]);
    },
  },
  {
    accessorKey: 'correct_answers_count',
    header: () => h('div', 'Réponses correctes'),
    meta: { title: 'Réponses correctes' },
    cell: ({ row }) => {
      return h(
        'div',
        {
          class: `font-bold rounded p-0.5 max-w-fit px-2 border ${getQuizResultColorCount(row.original?.correct_answers_count)} flex`,
        },
        `${row.original.correct_answers_count.toString()} / 20`,
      );
    },
  },
  {
    accessorKey: 'score',
    header: () => h('div', 'Score'),
    meta: { title: 'Score' },
    cell: ({ row }) => {
      return h(ResultScoreBadge, { score: row.original.score });
    },
  },
  {
    accessorKey: 'completed_in',
    header: () => h('div', 'Durée'),
    meta: { title: 'Durée' },
    cell: ({ row }) => {
      return h('div', { class: 'font-medium' }, convertMillisecondsToTimeFormat(row.original.completed_in));
    },
  },
  {
    accessorKey: 'completed_at',
    header: () => h('div', 'Complété le'),
    meta: { title: 'Complété le' },
    cell: ({ row }) => {
      return h('div', { class: 'font-medium' }, row.original.completed_at);
    },
  },
  {
    id: 'actions',
    header: () => h('div', { class: 'text-right' }, 'Actions'),
    meta: { title: 'Actions' },
    cell: ({ row, table }) => {
      const result = row.original;
      const meta = table.options.meta as {
        onOpenDelete?: (result: ResultData) => void;
        onOpenView?: (result: ResultData) => void;
      };
      return h(
        'div',
        { class: 'flex justify-end' },
        h(ResultActions, { result: result, onOpenDelete: meta?.onOpenDelete, onOpenView: meta?.onOpenView }),
      );
    },
  },
];
