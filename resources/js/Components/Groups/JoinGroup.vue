<template>
  <div>
    <PrimaryButton @click="joinGroup" v-if="!group.auto_approval" class="capitalize">
      {{ $t("Request to Join") }}
    </PrimaryButton>
    <PrimaryButton @click="joinGroup" v-else class="capitalize">
      {{ $t("Join") }}
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

const joinGroup = () => {
  router.post(
    route("groups.join", group.slug),
    {},
    {
      onSuccess: () => {
        showToast("Group joined successfully");
      },
    }
  );
};
</script>
