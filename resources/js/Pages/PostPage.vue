<template>
  <Head title="Post Details" />
  <AppLayout>
    <section class="post-wrapper">
      <div class="post-container">
        <div class="mb-3">
          <UploadingPost />
        </div>
        <PostCard v-for="post in posts" :key="post.id" :post="post" />
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import PostCard from "@/Components/Posts/PostCard.vue";
import UploadingPost from "@/Components/Posts/UploadingPost.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed } from "vue";
import { useStore } from "vuex";

const props = defineProps({
  slug: {
    type: String,
    required: true,
  },
});
const store = useStore();

store.commit("Posts/clearPosts");
store.dispatch("Posts/fetchSinglePost", props.slug);
const posts = computed(() => store.state.Posts.posts);

console.log("posts", posts.value);
</script>

<style scoped>
.post-wrapper {
  display: flex;
  justify-content: center;
}
.post-container {
  width: 600px;
}
</style>
