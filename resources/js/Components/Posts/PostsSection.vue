<template>
  <section class="mt-3">
    <div v-if="posts.length > 0">
      <TransitionGroup class="flex flex-col gap-3" name="fade" tag="div">
        <PostCard v-for="post in posts" :key="post.id" :post="post" />
      </TransitionGroup>
    </div>
    <div v-else>
      <EmptyList />
    </div>
  </section>
</template>

<script setup>
import PostCard from "./PostCard.vue";
import EmptyList from "../EmptyList.vue";

const props = defineProps({
  posts: {
    type: Array,
    required: true,
  },
});
</script>
