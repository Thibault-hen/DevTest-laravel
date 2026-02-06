import UserAvatar from '@/components/settings/user/UserAvatar.vue';
import { UserData } from '@/types/generated';
import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import { AdminBadge, TwoFactorConfirmedBadge, VerifiedEmailBadge } from '../../shared/badges';
import UserActions from './UserActions.vue';

export const usersColumns: ColumnDef<UserData>[] = [
  {
    accessorKey: 'id',
    header: () => h('div', '#'),
    meta: { title: 'id' },
    cell: ({ row }) => {
      return h('div', { class: 'font-bold' }, row.index + 1);
    },
  },
  {
    accessorKey: 'avatar',
    header: () => '',
    cell: ({ row }) => h(UserAvatar, { user: row.original }),
  },
  {
    id: 'name',
    header: () => h('div', 'Utilisateur'),
    meta: { title: 'Utilisateur' },
    cell: ({ row }) => {
      return h('div', { class: 'flex flex-col' }, [
        h('span', { class: 'font-medium flex items-center gap-2' }, [
          row.original.name ?? 'Utilisateur supprimé',
          h(AdminBadge, { user: row.original }),
        ]),
        h('span', { class: 'font-bold text-xs' }, row.original.email ?? ''),
      ]);
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
    accessorKey: 'email_verified_at',
    header: () => h('div', 'Email vérifié'),
    meta: { title: 'Email vérifié' },
    cell: ({ row }) => {
      return h(VerifiedEmailBadge, { user: row.original });
    },
  },
  {
    accessorKey: 'two_factor_confirmed_at',
    header: () => h('div', '2FA'),
    meta: { title: '2FA' },
    cell: ({ row }) => {
      return h(TwoFactorConfirmedBadge, { user: row.original });
    },
  },
  {
    id: 'actions',
    header: () => h('div', { class: 'text-right' }, 'Actions'),
    meta: { title: 'Actions' },
    cell: ({ row, table }) => {
      const user = row.original;
      const meta = table.options.meta as {
        onOpenDelete?: (theme: UserData) => void;
        onOpenView?: (theme: UserData) => void;
      };
      return h(
        'div',
        { class: 'flex justify-end' },
        h(UserActions, { user: user, onOpenDelete: meta?.onOpenDelete, onOpenEdit: meta?.onOpenView }),
      );
    },
  },
];
