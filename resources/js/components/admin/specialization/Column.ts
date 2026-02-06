import { UserRoleBadge } from '@/components/shared/badges';
import UsersPerSpecCountBadge from '@/components/shared/badges/UsersPerSpecCountBadge.vue';
import { SpecializationData } from '@/types/generated';
import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import SpecializationActions from './SpecializationActions.vue';

export const specializationColumns: ColumnDef<SpecializationData>[] = [
  {
    accessorKey: 'id',
    header: () => h('div', '#'),
    meta: { title: 'id' },
    cell: ({ row }) => {
      return h('div', { class: 'font-bold' }, row.index + 1);
    },
  },
  {
    accessorKey: 'name',
    header: () => h('div', 'Nom'),
    meta: { title: 'Nom' },
    cell: ({ row }) => {
      return h(UserRoleBadge, { specialization: row.original });
    },
  },
  {
    accessorKey: 'users_count',
    header: () => h('div', "Nombre d'utilisateurs"),
    meta: { title: "Nombre d'utilisateurs" },
    cell: ({ row }) => {
      return h(UsersPerSpecCountBadge, { count: row.original.users_count ?? 0 });
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
      const specialization = row.original;
      const meta = table.options.meta as {
        onOpenDelete?: (specialization: SpecializationData) => void;
        onOpenEdit?: (specialization: SpecializationData) => void;
      };
      return h(
        'div',
        { class: 'flex justify-end' },
        h(SpecializationActions, {
          specialization,
          onOpenDelete: meta?.onOpenDelete,
          onOpenEdit: meta?.onOpenEdit,
        }),
      );
    },
  },
];
