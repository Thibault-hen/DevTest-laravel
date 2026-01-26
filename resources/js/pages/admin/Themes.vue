<script setup lang="ts">
import DataTable from '@/components/admin/DataTable.vue';
import { themesColumns } from '@/components/admin/themes/Column';
import AddThemeModal from '@/components/admin/themes/modals/AddThemeModal.vue';
import DeleteThemeModal from '@/components/admin/themes/modals/DeleteThemeModal.vue';
import EditThemeModal from '@/components/admin/themes/modals/EditThemeModal.vue';
import Button from '@/components/ui/button/Button.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { ThemeData } from '@/types/generated';
import { Head } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

const showAddModal = ref(false);
const showDeleteModal = ref(false);
const showEditModal = ref(false);
const selectedTheme = ref<ThemeData | null>(null);

const props = defineProps<{
  themes: ThemeData[];
}>();

const openAddModal = (): void => {
  showAddModal.value = true;
};

const openDeleteModal = (theme: ThemeData): void => {
  selectedTheme.value = theme;
  showDeleteModal.value = true;
  console.log('Deleting theme:', theme);
};

const openEditModal = (theme: ThemeData): void => {
  selectedTheme.value = theme;
  showEditModal.value = true;
  console.log('Editing theme:', theme);
};
</script>

<template>
  <AddThemeModal v-model="showAddModal" />
  <EditThemeModal
    v-model="showEditModal"
    :theme="selectedTheme"
  />
  <DeleteThemeModal
    v-model="showDeleteModal"
    :theme="selectedTheme"
  />
  <AdminLayout>
    <template #header-actions>
      <Button
        size="sm"
        variant="primary"
        @click="openAddModal"
      >
        <Plus class="w-4 h-4 mr-2" />
        Ajouter un thème
      </Button>
    </template>

    <Head title="Thèmes" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <DataTable
        :data="props.themes"
        :columns="themesColumns"
        :meta="{ onOpenDelete: openDeleteModal, onOpenEdit: openEditModal }"
      />
    </div>
  </AdminLayout>
</template>
