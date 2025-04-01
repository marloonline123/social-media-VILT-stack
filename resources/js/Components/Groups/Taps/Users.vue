<template>
  <Card class="mt-3">
    <section class="pb-6">
      <div class="text-center">
        <h3 class="text-3xl font-extrabold text-gray-800">👥 Group Members</h3>
        <p class="text-gray-500 mt-2">Meet our awesome team members!</p>
      </div>

      <div class="mt-8">
        <div
          v-if="members.length > 0"
          class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6"
        >
          <MemberCard
            v-for="member in members"
            :member="member"
            :group="group"
            :key="member.id"
          />
        </div>
        <p v-else class="text-center text-gray-500 mt-4">
          There is no members in this group yet.
        </p>
      </div>
    </section>
  </Card>
</template>

<script setup>
import Card from "@/Components/Card.vue";
import MemberCard from "./Partials/MemberCard.vue";

defineProps({
  group: {
    type: Object,
    required: true,
  },
  members: {
    type: Array,
    required: true,
  },
});
</script>
