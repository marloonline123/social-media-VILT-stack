<template>
  <section class="mt-3">
    <div class="">
      <TransitionGroup class="flex flex-col gap-3" name="fade" tag="div">
        <PostCard v-for="post in posts" :key="post.id" :post="post"/>
      </TransitionGroup>
    </div>
  </section>
</template>

<script setup>
import { computed } from "vue";
import PostCard from "./PostCard.vue";

const props = defineProps({
  posts: {
    type: Array,
    required: true,
  },
})

// const postsData = computed(() => props.posts.data);
</script>
