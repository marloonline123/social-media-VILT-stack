<template>
  <div>
    <div>
      <PrimaryButton
        @click="openModal"
        v-show="group.user_id === $page.props.auth?.user?.id"
        class="capitalize"
      >
        {{ $t("Invite Members") }}
      </PrimaryButton>
    </div>

    <div>
      <Modal :show="isOpen" @close="closeModal" :title="$t('Invite Members')">
        <div class="my-4 px-2">
          <div>
            <InputLabel class="mb-2">{{ $t("Email / Username") }}</InputLabel>
            <TextInput
              v-model="form.invited_member"
              type="text"
              placeholder="Enter User Email or Username"
            />
            <InputError class="mt-2" :message="form.errors.invited_member" />
          </div>
        </div>
        <template #footer>
          <PrimaryButton
            @click="inviteMember"
            :disabled="form.processing"
            class="capitalize"
          >
            {{ $t("Invite") }}
          </PrimaryButton>
        </template>
      </Modal>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Modal from "../Modal/Modal.vue";
import PrimaryButton from "../PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import InputLabel from "../InputLabel.vue";
import TextInput from "../TextInput.vue";
import { useToast } from "@/Utl/useToast";
import InputError from "../InputError.vue";

const { group } = defineProps({
  group: {
    type: Object,
    required: true,
  },
});

const isOpen = ref(false);
const { showToast } = useToast();
const form = useForm({
  invited_member: "",
});

const inviteMember = () => {
  //   if (!form.invited_member) return;

  form.post(route("groups.invite", group.slug), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      showToast("Member invited successfully");
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
