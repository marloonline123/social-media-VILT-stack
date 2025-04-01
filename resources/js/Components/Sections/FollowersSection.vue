<template>
  <section class="">
    <h3 class="text-lg font-bold mb-2">{{ $t("Followers") }}</h3>
    <div>
      <div v-if="followers.length > 0" class="flex flex-col">
        <UserCard v-for="follower in followers" :key="follower.id" :user="follower" />
      </div>
      <div v-else>
        <EmptyList />
      </div>
    </div>
  </section>
</template>

<script setup>
import EmptyList from "../EmptyList.vue";
import UserCard from "./UserCard.vue";
defineProps({
  followers: {
    type: Array,
    required: true,
  },
});
</script>
