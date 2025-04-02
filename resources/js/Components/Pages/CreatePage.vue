<template>
  <div>
    <div>
      <DropdownButton @click="openModal">{{ $t("Create Page") }}</DropdownButton>
    </div>

    <div>
      <Modal :show="isOpen" @close="closeModal" :title="$t('Create Page')">
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
              @click="createPage"
              :disabled="form.processing"
              class="text-lg"
            >
              {{ $t("Create") }}
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
import DropdownButton from "../DropdownButton.vue";
import TextInput from "../TextInput.vue";
import InputLabel from "../InputLabel.vue";
import { useForm } from "@inertiajs/vue3";
import TextArea from "../TextArea.vue";
import PrimaryButton from "../PrimaryButton.vue";
import InputError from "../InputError.vue";
import { useToast } from "@/Utl/useToast";

const isOpen = ref(false);
const emit = defineEmits(["close-dropdown"]);
const { showToast } = useToast();
const form = useForm({
  name: "",
  about: "",
});

const createPage = () => {
  form.post(route("pages.store"), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      showToast("Page created successfully");
    },
  });
};

const openModal = () => {
  isOpen.value = true;
};

const closeModal = () => {
  isOpen.value = false;
  form.reset();
  emit("close-dropdown");
};
</script>
