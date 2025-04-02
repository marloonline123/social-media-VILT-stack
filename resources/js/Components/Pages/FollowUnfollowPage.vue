<template>
  <div class="flex gap-2 flex-row md:flex-col">
    <PrimaryButton @click="followToggle">{{
      page.isFollowing ? "Unfollow" : "Follow"
    }}</PrimaryButton>
  </div>
</template>

<script setup>
import PrimaryButton from "../PrimaryButton.vue";
import { router } from "@inertiajs/vue3";

const { page } = defineProps({
  page: {
    type: Object,
    required: true,
  },
});

console.log("page", page);

const followToggle = () => {
  router.post(
    route("pages.follow-toggle", page.id),
    {},
    {
      preserveScroll: true,
    }
  );
};
</script>
