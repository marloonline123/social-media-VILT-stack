<template>
  <div>
    <DropdownButton icon="fa-solid fa-trash" @click.stop="isDeleting = true">{{
      $t("Delete")
    }}</DropdownButton>

    <Modal :show="isDeleting" @close="closeModal" :title="$t('Delete Comment')">
      <div class="my-4 text-center">
        {{
          $t(
            "Are you sure you want to delete this Comment? This action cannot be undone."
          )
        }}
      </div>
      <template #footer>
        <PrimaryButton
          @click="deleteComment"
          :disabled="isLoading"
          class="text-lg bg-red-400 hover:bg-red-500 active:bg-red-600 focus:bg-red-500 focus:ring-red-500"
          icon="fa-regular fa-paper-plane"
          >{{ $t("Delete") }}
        </PrimaryButton>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref } from "vue";
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
const isDeleting = ref(false);
const isLoading = ref(false);

const deleteComment = async () => {
  isLoading.value = true;
  await store.dispatch("Posts/deletePostComment", {
    id: comment.id,
    postId: comment.post.id,
    commentId: comment.comment_id,
  });
  closeModal();
  isLoading.value = false;
  showToast(t("Comment Updated successfully"));
};

const closeModal = () => {
  isDeleting.value = false;
  emit("close-dropdown");
};
</script>
