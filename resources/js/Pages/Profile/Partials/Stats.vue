<template>
  <div class="flex space-x-6 mt-4 md:mt-0">
    <div class="text-center">
      <p class="text-xl font-bold">{{ user.posts_count }}</p>
      <p class="text-sm text-gray-500">Posts</p>
    </div>
    <div class="text-center">
      <p class="text-xl font-bold">{{ user.followers_count }}</p>
      <p class="text-sm text-gray-500">Followers</p>
    </div>
    <div class="text-center">
      <p class="text-xl font-bold">{{ user.followings_count }}</p>
      <p class="text-sm text-gray-500">Following</p>
    </div>
    <div class="text-center">
      <p class="text-xl font-bold">{{ user.likes_count }}</p>
      <p class="text-sm text-gray-500">Likes</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  user: {
    type: Object,
    required: true,
  },
});
</script>
