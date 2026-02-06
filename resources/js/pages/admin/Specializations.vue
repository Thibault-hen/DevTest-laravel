<script setup lang="ts">
import DataTable from '@/components/admin/DataTable.vue';
import { specializationColumns } from '@/components/admin/specialization/Column';
import {
  AddSpecializationModal,
  DeleteSpecializationModal,
  EditSpecializationModal,
} from '@/components/admin/specialization/modals';
import Button from '@/components/ui/button/Button.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { SpecializationData } from '@/types/generated';
import { Head } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{ specializations: SpecializationData[] }>();

const showAddModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedSpecialization = ref<SpecializationData | null>(null);

const openEditModal = (specialization: SpecializationData): void => {
  selectedSpecialization.value = specialization;
  showEditModal.value = true;
};

const openAddModal = (): void => {
  showAddModal.value = true;
};

const openDeleteModal = (specialization: SpecializationData): void => {
  selectedSpecialization.value = specialization;
  showDeleteModal.value = true;
};
</script>

<template>
  <AdminLayout>
    <AddSpecializationModal v-model="showAddModal" />
    <EditSpecializationModal
      v-model="showEditModal"
      :specialization="selectedSpecialization"
    />
    <DeleteSpecializationModal
      v-model="showDeleteModal"
      :specialization="selectedSpecialization"
    />
    <template #header-actions>
      <Button
        size="sm"
        variant="primary"
        @click="openAddModal"
      >
        <Plus class="w-4 h-4 mr-2" />
        Ajouter une spécialisation
      </Button>
    </template>

    <Head title="Spécialisations" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <DataTable
        :data="props.specializations"
        :columns="specializationColumns"
        :meta="{ onOpenEdit: openEditModal, onOpenDelete: openDeleteModal }"
      />
    </div>
  </AdminLayout>
</template>
