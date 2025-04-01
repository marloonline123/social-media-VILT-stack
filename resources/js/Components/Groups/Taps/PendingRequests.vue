<template>
  <Card class="mt-3">
    <section class="py-6">
      <div class="text-center">
        <h3 class="text-3xl font-extrabold text-gray-800">📩 Member Requests</h3>
        <p class="text-gray-500 mt-2">
          Review and manage pending requests to join the group.
        </p>
      </div>

      <div class="mt-8">
        <div v-if="requests.length > 0" class="flex flex-wrap items-center gap-6">
          <PendingRequestCard
            v-for="request in requests"
            :group="group"
            :request="request"
            :key="request.id"
          />
        </div>
        <p v-else class="text-center text-gray-500 mt-4">
          There is no pending requests to join the group.
        </p>
      </div>
    </section>
  </Card>
</template>

<script setup>
import Card from "@/Components/Card.vue";
import PendingRequestCard from "./Partials/PendingRequestCard.vue";

defineProps({
  group: {
    type: Object,
    required: true,
  },
  requests: {
    type: Array,
    required: true,
  },
});
</script>
