<template>
  <div class="">
    <div>
      <div class="mb-4">
        <CreatePost />
      </div>

      <div>
        <StoriesSection />
      </div>

      <PostsSection :posts="posts" />
    </div>
  </div>
</template>

<script setup>
import StoriesSection from "../Sections/StoriesSection.vue";
import PostsSection from "../Posts/PostsSection.vue";
import CreatePost from "../Posts/CreatePost.vue";

const props = defineProps({
  posts: {
    type: Object,
    required: true,
  },
});

</script>
