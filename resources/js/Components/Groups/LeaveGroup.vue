<template>
  <div>
    <PrimaryButton @click="leaveGroup" class="capitalize">
      {{ $t("Leave") }}
    </PrimaryButton>
  </div>
</template>

<script setup>
import { useToast } from "@/Utl/useToast";
import PrimaryButton from "../PrimaryButton.vue";
import { router } from "@inertiajs/vue3";

const { group } = defineProps({
  group: {
    type: Object,
    required: true,
  },
});
const { showToast } = useToast();

const leaveGroup = () => {
  router.post(
    route("groups.leave", group.slug),
    {},
    {
      onSuccess: () => {
        showToast("Group left successfully");
      },
    }
  );
};
</script>
