<template>
  <div>
    <DropdownButton icon="fa-solid fa-pencil" @click.stop="isEditing = true">{{
      $t("Edit")
    }}</DropdownButton>

    <Modal :show="isEditing" @close="closeModal" :title="$t('Edit Comment')">
      <div class="my-4 px-2 text-center">
        <textarea
          :placeholder="$t('Write a reply...')"
          v-model="form.body"
          class="w-full text-sm px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900 dark:text-white resize-none transition"
          rows="2"
        ></textarea>
      </div>
      <template #footer>
        <PrimaryButton
          @click="updateComment"
          :disabled="isLoading"
          class="text-lg"
          icon="fa-regular fa-paper-plane"
        >
          {{ $t("Save") }}
        </PrimaryButton>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "@/Utl/useToast";
import { useI18n } from "vue-i18n";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal/Modal.vue";
import DropdownButton from "@/Components/DropdownButton.vue";
import { useStore } from "vuex";

const { comment } = defineProps({
  comment: {
    type: Object,
    required: true,
  },
});

const { showToast } = useToast();
const { t } = useI18n();
const emit = defineEmits(["close-dropdown"]);
const store = useStore();
const isLoading = ref(false);
const isEditing = ref(false);
const form = useForm({
  body: comment.body,
  _method: "put",
});

const updateComment = async () => {
  if (form.body.trim() === "") {
    form.errors.body = "Comment cannot be empty.";
    return;
  }
  isLoading.value = true;
  await store.dispatch("Posts/updateComment", { id: comment.id, body: form.body });
  closeModal();
  form.reset();
  isLoading.value = false;
  showToast(t("Comment Updated successfully"));
};

const closeModal = () => {
  isEditing.value = false;
  emit("close-dropdown");
};
</script>
