<template>
  <div>
    <CreatePostOverlay :openModal="openModal" />
    <Modal :show="modalOpened" @close="closeModal" :title="$t('Create Post')">
      <ValidationError :for="errors.body" class="mx-1" />
      <EditorComponent
        v-if="modalOpened"
        @update:body="updateBody"
        @update:attachments="updateAttachments"
        :modalOpened="modalOpened"
        :body="form.body"
      />

      <template #footer>
        <div class="flex gap-2">
          <PrimaryButton
            @click="createPost"
            :disabled="form.processing || uploading"
            class="text-lg"
            icon="fa-regular fa-paper-plane"
          >
            {{ $t("Save") }}
          </PrimaryButton>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "../PrimaryButton.vue";
import { useToast } from "@/Utl/useToast";
import { useI18n } from "vue-i18n";
import Modal from "../Modal/Modal.vue";
import CreatePostOverlay from "./CreatePostOverlay.vue";
import EditorComponent from "./EditorComponent.vue";
import ValidationError from "../ValidationError.vue";
import { useUploadPost } from "@/Composables/useUploadPost";
import { useStore } from "vuex";
import useTextValidation from "@/Composables/useTextValidation";
import useAttachmentValidation from "@/Composables/useAttachmentValidation";

const { group } = defineProps({
  group: {
    type: Object,
    required: false,
  },
});

const { showToast } = useToast();
const { t } = useI18n();
const { uploadPost } = useUploadPost();

const modalOpened = ref(false);

const form = useForm({
  group_id: group?.id ?? null,
  body: "",
  attachments: [],
});

const errors = ref({
  body: "",
  attachments: [],
});
const store = useStore();
const uploading = ref(false);
const uploadProgress = ref([]);

const updateBody = (body) => {
  form.body = body;
};

const updateAttachments = (attachments) => {
  form.attachments = attachments || [];
  uploadProgress.value = [];
};

const { validateData } = useTextValidation(errors, form);
const { validateAttachments } = useAttachmentValidation(errors);

const createPost = () => {
  if (!validateData()) return false;
  if (!validateAttachments(form.attachments)) return false;
  store.dispatch("Upload/uploadPost", {
    body: form.body,
    attachments: form.attachments,
    group_id: form.group_id ?? null,
  });
  closeModal();
};

const openModal = () => {
  modalOpened.value = true;
};

const closeModal = () => {
  form.reset();
  errors.value = {
    body: "",
    attachments: [],
  };
  modalOpened.value = false;
};
</script>
