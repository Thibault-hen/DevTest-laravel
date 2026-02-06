<script setup lang="ts">
import { categoriesColumn } from '@/components/admin/category/Column';
import { AddCategoryModal, DeleteCategoryModal, EditCategoryModal } from '@/components/admin/category/modals';
import DataTable from '@/components/admin/DataTable.vue';
import Button from '@/components/ui/button/Button.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { CategoryData } from '@/types/generated';
import { Head } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{ categories: CategoryData[] }>();

const showAddModal = ref(false);
const showDeleteModal = ref(false);
const showEditModal = ref(false);
const selectedCategory = ref<CategoryData | null>(null);

const openAddModal = (): void => {
  showAddModal.value = true;
};

const openDeleteModal = (category: CategoryData): void => {
  selectedCategory.value = category;
  showDeleteModal.value = true;
};

const openEditModal = (category: CategoryData): void => {
  selectedCategory.value = category;
  showEditModal.value = true;
};
</script>

<template>
  <AdminLayout>
    <AddCategoryModal v-model="showAddModal" />
    <EditCategoryModal
      v-model="showEditModal"
      :category="selectedCategory"
    />
    <DeleteCategoryModal
      v-model="showDeleteModal"
      :category="selectedCategory"
    />
    <template #header-actions>
      <Button
        size="sm"
        variant="primary"
        @click="openAddModal()"
      >
        <Plus class="w-4 h-4 mr-2" />
        Ajouter une catégorie
      </Button>
    </template>

    <Head title="Catégories" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <DataTable
        :data="props.categories"
        :columns="categoriesColumn"
        :meta="{ onOpenEdit: openEditModal, onOpenDelete: openDeleteModal }"
      />
    </div>
  </AdminLayout>
</template>
