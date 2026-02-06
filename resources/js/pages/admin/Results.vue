<script setup lang="ts">
import DataTable from '@/components/admin/DataTable.vue';
import { resultColumns } from '@/components/admin/result/Column';
import { DeleteResultModal, ViewResultModal } from '@/components/admin/result/modals';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { ResultData } from '@/types/generated';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps<{
  results: ResultData[];
}>();

const selectedResult = ref<ResultData | null>(null);
const showViewModal = ref(false);
const showDeleteModal = ref(false);

const openViewModal = (result: ResultData): void => {
  selectedResult.value = result;
  showViewModal.value = true;
};

const openDeleteModal = (result: ResultData): void => {
  selectedResult.value = result;
  showDeleteModal.value = true;
};
</script>

<template>
  <AdminLayout>
    <ViewResultModal
      v-model="showViewModal"
      :quiz_result="selectedResult ?? null"
    />
    <DeleteResultModal
      v-model="showDeleteModal"
      :result="selectedResult ?? null"
    />
    <Head title="Résultats" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <DataTable
        :data="props.results"
        :columns="resultColumns"
        :meta="{ onOpenView: openViewModal, onOpenDelete: openDeleteModal }"
      />
    </div>
  </AdminLayout>
</template>
