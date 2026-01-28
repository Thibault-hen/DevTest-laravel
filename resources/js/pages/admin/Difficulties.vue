<script setup lang="ts">
import DataTable from '@/components/admin/DataTable.vue';
import { difficultyColumns } from '@/components/admin/difficulty/Column';
import { AddDifficultyModal, DeleteDifficultyModal, EditDifficultyModal } from '@/components/admin/difficulty/modals';
import Button from '@/components/ui/button/Button.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { DifficultyData } from '@/types/generated';
import { Head } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{ difficulties: DifficultyData[] }>();

const showAddModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedDifficulty = ref<DifficultyData | null>(null);

const openAddModal = (): void => {
  showAddModal.value = true;
};

const openEditModal = (difficulty: DifficultyData): void => {
  selectedDifficulty.value = difficulty;
  showEditModal.value = true;
};

const openDeleteModal = (difficulty: DifficultyData): void => {
  selectedDifficulty.value = difficulty;
  showDeleteModal.value = true;
};
</script>

<template>
  <AdminLayout>
    <AddDifficultyModal v-model="showAddModal" />
    <EditDifficultyModal
      v-model="showEditModal"
      :difficulty="selectedDifficulty"
    />
    <DeleteDifficultyModal
      v-model="showDeleteModal"
      :difficulty="selectedDifficulty"
    />
    <template #header-actions>
      <Button
        size="sm"
        variant="primary"
        @click="openAddModal"
      >
        <Plus class="w-4 h-4 mr-2" />
        Ajouter une difficulté
      </Button>
    </template>

    <Head title="Difficultés" />
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <DataTable
        :data="props.difficulties"
        :columns="difficultyColumns"
        :meta="{ onOpenEdit: openEditModal, onOpenDelete: openDeleteModal }"
      />
    </div>
  </AdminLayout>
</template>
