<template>
  <Card class="mt-3">
    <section class="py-6">
      <div class="text-center">
        <h3 class="text-3xl font-extrabold text-gray-800">👤 User Followers</h3>
        <p class="text-gray-500 mt-2">Check out who follows this user!</p>
      </div>

      <div class="mt-8">
        <div
          v-if="followings.length > 0"
          class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6"
        >
          <FollowingCard
            v-for="following in followings"
            :following="following"
            :user="user"
            :key="following.id"
          />
        </div>
        <p v-else class="text-center text-gray-500 mt-4">
          This user does not follow anyone
        </p>
      </div>
    </section>
  </Card>
</template>

<script setup>
import Card from "@/Components/Card.vue";
import FollowingCard from "./Partials/FollowingCard.vue";

defineProps({
  user: {
    type: Object,
    required: true,
  },
  followings: {
    type: Array,
    required: true,
  },
});
</script>
