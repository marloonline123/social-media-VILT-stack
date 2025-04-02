<template>
  <div>
    <div>
      <PrimaryButton class="" @click="openModal">{{ $t("Edit") }}</PrimaryButton>
    </div>

    <div>
      <Modal :show="isOpen" @close="closeModal" :title="$t('Edit Page')">
        <div class="my-4 px-2 flex flex-col space-y-4">
          <div>
            <InputLabel class="mb-2">{{ $t("Name") }}</InputLabel>
            <TextInput v-model="form.name" />
            <InputError :message="form.errors.name" />
          </div>
          <div class="w-full">
            <InputLabel class="mb-2">{{ $t("About") }}</InputLabel>
            <TextArea class="w-full" v-model="form.about"></TextArea>
            <InputError :message="form.errors.about" />
          </div>
        </div>
        <template #footer>
          <div>
            <PrimaryButton
              @click="updatePage"
              :disabled="form.processing"
              class="text-lg"
            >
              {{ $t("update") }}
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

const { page } = defineProps({
  page: {
    type: Object,
    required: true,
  },
});

const isOpen = ref(false);
const { showToast } = useToast();
const form = useForm({
  name: page.name,
  about: page.about,
  _method: "PUT",
});

const updatePage = () => {
  form.post(route("pages.update", page.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      showToast("Page Updated successfully");
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
