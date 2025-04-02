<template>
  <div>
    <div>
      <PrimaryButton
        class="bg-red-500 hover:bg-red-600 active:bg-red-600 focus:bg-red-600 focus:ring-red-500"
        @click="openModal"
        >{{ $t("Delete") }}</PrimaryButton
      >
    </div>

    <div>
      <Modal :show="isOpen" @close="closeModal" :title="$t('Delete Page')">
        <div class="my-4 text-center">
          {{
            $t("Are you sure you want to delete this page? This action cannot be undone.")
          }}
        </div>
        <template #footer>
          <div>
            <PrimaryButton
              @click="deletePage"
              :disabled="form.processing"
              class="bg-red-500 hover:bg-red-600 active:bg-red-600 focus:bg-red-600 focus:ring-red-500"
            >
              {{ $t("delete") }}
            </PrimaryButton>
          </div>
        </template>
      </Modal>
    </div>
  </div>
</template>

<script setup>
import Modal from "@/Components/Modal/Modal.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "../PrimaryButton.vue";
import { useToast } from "@/Utl/useToast";

const { page } = defineProps({
  page: {
    type: Object,
    required: true,
  },
});

const isOpen = ref(false);
const { showToast } = useToast();
const form = useForm({
  _method: "DELETE",
});

const deletePage = () => {
  form.post(route("pages.destroy", page.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      showToast("Page Deleted successfully");
    },
  });
};

const openModal = () => {
  isOpen.value = true;
};

const closeModal = () => {
  isOpen.value = false;
  form.reset();
};
</script>
