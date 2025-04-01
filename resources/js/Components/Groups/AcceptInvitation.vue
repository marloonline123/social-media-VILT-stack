<template>
  <Modal :show="isOpen" @close="closeModal">
    <div class="text-center p-5">
      <!-- Animated Icon -->
      <div class="flex items-center justify-center mb-4">
        <div
          class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600 text-white text-3xl font-bold shadow-md"
        >
          🎉
        </div>
      </div>

      <!-- Invitation Message -->
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
        {{ group.name + $t(" Has Invited you to join their Group!") }}
      </h2>
      <p class="text-gray-600 dark:text-gray-300 mt-2">
        {{
          $t(
            "You have received an exclusive invitation to join our special community. This is your chance to connect with amazing people and explore new opportunities!"
          )
        }}
      </p>

      <!-- Buttons -->
      <div class="mt-6 flex justify-center space-x-4">
        <button
          @click="declineInvitation"
          class="px-4 py-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition"
        >
          {{ $t("Decline") }}
        </button>
        <button
          @click="acceptInvitation"
          class="px-6 py-2 text-white bg-gradient-to-r from-blue-500 to-purple-600 hover:scale-105 transition-transform rounded-lg shadow-md"
        >
          {{ $t("Accept Invitation") }}
        </button>
      </div>
    </div>
    <!-- </div> -->
  </Modal>
</template>

<script setup>
import { ref, watch } from "vue";
import Modal from "../Modal.vue";
import { useToast } from "@/Utl/useToast";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  group: {
    type: Object,
    required: true,
  },
  openInvitation: {
    type: Boolean,
    required: true,
  },
});

const isOpen = ref(false);
const { showToast } = useToast();

watch(
  () => props.openInvitation,
  (newVal) => {
    console.log("newVal", newVal);
    isOpen.value = newVal;
  },
  { immediate: true }
);

const acceptInvitation = () => {
  router.post(
    route("groups.invitation.accept", props.group.slug),
    {},
    {
      onSuccess: () => {
        showToast("🎉 Invitation accepted! Welcome aboard!");
        closeModal();
      },
      preserveScroll: true,
    }
  );
};

const declineInvitation = () => {
  router.post(
    route("groups.invitation.decline", props.group.slug),
    {},
    {
      onSuccess: () => {
        showToast("🎉 Invitation Decline!");
        closeModal();
      },
      preserveScroll: true,
    }
  );
};

const openModal = () => {
  isOpen.value = true;
};

const closeModal = () => {
  isOpen.value = false;
};
</script>
