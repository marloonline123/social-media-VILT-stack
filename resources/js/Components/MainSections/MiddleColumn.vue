<template>
  <div>
    <div class="mb-3">
      <CreatePost />
    </div>

    <div class="mb-3">
      <Transition name="fade">
        <UploadingPost />
      </Transition>
    </div>

    <div>
      <StoriesSection />
    </div>

    <PostsSection :posts="posts" />

    <!-- Loader -->
    <LoadMorePosts :posts="posts" />
  </div>
</template>

<script setup>
import { computed } from "vue";
import StoriesSection from "../Sections/StoriesSection.vue";
import PostsSection from "../Posts/PostsSection.vue";
import CreatePost from "../Posts/CreatePost.vue";
import UploadingPost from "../Posts/UploadingPost.vue";
import { useStore } from "vuex";
import LoadMorePosts from "../Sections/LoadMorePosts.vue";

const store = useStore();
store.commit("Posts/clearPosts");
store.dispatch("Posts/fetchPosts");
const posts = computed(() => store.state.Posts.posts);
</script>
