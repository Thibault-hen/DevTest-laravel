<script setup lang="ts">
import DataTable from '@/components/admin/DataTable.vue';
import { usersColumns } from '@/components/admin/user/Column';
import { ViewUserModal } from '@/components/admin/user/modals';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { UserData } from '@/types/generated';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
  users: UserData[];
}>();

const showViewModal = ref(false);
const showDeleteModal = ref(false);
const selectedUser = ref<UserData | null>(null);

const openViewModal = (user: UserData): void => {
  selectedUser.value = user;
  showViewModal.value = true;
  console.log('Opening view modal for user:', user);
};

const openDeleteModal = (user: UserData): void => {
  selectedUser.value = user;
  showDeleteModal.value = true;
};
</script>

<template>
  <AdminLayout>
    <ViewUserModal
      :user="selectedUser"
      v-model="showViewModal"
    />
    <Head title="Utilisateurs" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <DataTable
        :data="props.users"
        :columns="usersColumns"
        :meta="{ onOpenView: openViewModal, onOpenDelete: openDeleteModal }"
      />
    </div>
  </AdminLayout>
</template>
