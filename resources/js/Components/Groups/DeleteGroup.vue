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
      <Modal :show="isOpen" @close="closeModal" :title="$t('Delete Group')">
        <div class="my-4 text-center">
          {{
            $t(
              "Are you sure you want to delete this group? This action cannot be undone."
            )
          }}
        </div>
        <template #footer>
          <div>
            <PrimaryButton
              @click="deleteGroup"
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
import TextInput from "../TextInput.vue";
import InputLabel from "../InputLabel.vue";
import { useForm } from "@inertiajs/vue3";
import Checkbox from "../Checkbox.vue";
import TextArea from "../TextArea.vue";
import PrimaryButton from "../PrimaryButton.vue";
import InputError from "../InputError.vue";
import { useToast } from "@/Utl/useToast";

const { group } = defineProps({
  group: {
    type: Object,
    required: true,
  },
});

const isOpen = ref(false);
const { showToast } = useToast();
const form = useForm({
  _method: "DELETE",
});

const deleteGroup = () => {
  form.post(route("groups.destroy", group.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      showToast("Group Deleted successfully");
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
