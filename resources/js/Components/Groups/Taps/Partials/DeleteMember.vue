<template>
  <div>
    <DropdownButton icon="fa-solid fa-trash" @click.stop="isDeleting = true">{{
      $t("Delete")
    }}</DropdownButton>

    <Modal :show="isDeleting" @close="closeModal" :title="$t('Remove Member')">
      <div class="my-4 text-center">
        {{
          $t("Are you sure you want to remove this member? This action cannot be undone.")
        }}
      </div>
      <template #footer>
        <PrimaryButton
          @click="deleteMember"
          :disabled="isLoading"
          class="text-lg bg-red-400 hover:bg-red-500 active:bg-red-600 focus:bg-red-500 focus:ring-red-500"
          icon="fa-regular fa-paper-plane"
          >{{ $t("Remove") }}
        </PrimaryButton>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import { useToast } from "@/Utl/useToast";
import { useI18n } from "vue-i18n";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal/Modal.vue";
import DropdownButton from "@/Components/DropdownButton.vue";

const { member } = defineProps({
  member: {
    type: Object,
    required: true,
  },
});

const { showToast } = useToast();
const { t } = useI18n();
const emit = defineEmits(["close-dropdown"]);
const isDeleting = ref(false);
const isLoading = ref(false);

const deleteMember = () => {
  isLoading.value = true;
  router.post(
    route("groups.remove-member", member.group.slug),
    {
      member_id: member.id,
    },
    {
      onSuccess: () => {
        emit("close-dropdown");
        closeModal();
        showToast(t("Member removed successfully"));
        isLoading.value = false;
      },
    }
  );
};

const closeModal = () => {
  isDeleting.value = false;
  emit("close-dropdown");
};
</script>
