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
    <div v-if="loading" class="text-center my-4">Loading more posts...</div>

    <div id="loadMore" ref="loadMoreTrigger"></div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import StoriesSection from "../Sections/StoriesSection.vue";
import PostsSection from "../Posts/PostsSection.vue";
import CreatePost from "../Posts/CreatePost.vue";
import UploadingPost from "../Posts/UploadingPost.vue";
import { useStore } from "vuex";

const store = useStore();
const offset = ref(0);
store.dispatch("Posts/fetchPosts");
const posts = computed(() => store.state.Posts.posts);

console.log("fetchedPosts", posts.value);

const loading = ref(false);
const loadMoreTrigger = ref(null);

const loadMore = async () => {
  if (loading.value) return;

  loading.value = true;
  await store.dispatch("Posts/fetchPosts", (offset.value += 10));
  loading.value = false;
};

onMounted(() => {
  setTimeout(() => {
    if (!loadMoreTrigger.value) {
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        if (entries[0].isIntersecting) {
          loadMore();
        }
      },
      { rootMargin: "100px" }
    );

    observer.observe(loadMoreTrigger.value);
  }, 100);
});
</script>
