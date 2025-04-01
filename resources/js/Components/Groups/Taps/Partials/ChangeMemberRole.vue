<template>
  <div>
    <div>
      <DropdownButton @click="openModal">Change Role</DropdownButton>
    </div>
    <div>
      <Modal @close="closeModal" :show="isOpen" title="Change Role">
        <div class="my-4 px-2 flex flex-col space-y-4">
          <div>
            <InputLabel class="mb-2">Role</InputLabel>
            <select
              class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
              name="role"
              id="role"
              v-model="form.role"
            >
              <option value="admin" class="text-gray-900">Admin</option>
              <option value="user" class="text-gray-900">Member</option>
            </select>
          </div>
        </div>

        <template #footer>
          <PrimaryButton
            :disabled="form.processing"
            @click="changeRole"
            class="capitalize"
            >Save</PrimaryButton
          >
        </template>
      </Modal>
    </div>
  </div>
</template>

<script setup>
import DropdownButton from "@/Components/DropdownButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useToast } from "@/Utl/useToast";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const { member } = defineProps({
  member: {
    type: Object,
    required: true,
  },
});

const isOpen = ref(false);
const { showToast } = useToast();
const emit = defineEmits(["close-dropdown"]);
const form = useForm({
  role: member.role,
  member_id: member.id,
});

const changeRole = () => {
  form.post(route("groups.change-role", member.group.slug), {
    onSuccess: () => {
      closeModal();
      showToast("Role changed successfully");
    },
    preserveScroll: true,
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
