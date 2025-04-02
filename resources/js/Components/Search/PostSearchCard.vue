<template>
  <Link
    :href="route('posts.show', post.slug)"
    class="bg-white dark:bg-slate-700 border-2 rounded-md p-3 mb-2 block hover:shadow-md"
  >
    <div class="flex items-center justify-between">
      <PostWritter :post="post" />
    </div>

    <div class="mt-5">
      <PostContent :post="post" />
      <div v-if="post.likes_count > 0" class="mt-3 flex items-center gap-1">
        <i class="fa-solid fa-heart text-rose-600"></i>
        <span v-if="post.likes_count == 1"
          >{{ post.liked ? "You " : "One person" }} liked this post</span
        >
        <span v-else
          >{{
            (post.liked ? "You and " : "") +
            (post.likes_count - 1) +
            (post.likes_count - 1 > 1 ? " others" : " person")
          }}
          liked this post</span
        >
      </div>
    </div>
  </Link>
</template>

<script setup>
import PostWritter from "@/Components/Posts/PostWritter.vue";
import PostContent from "@/Components/Posts/PostContent.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
});
</script>

<style>
#post-body a {
  @apply text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600 duration-200;
}
</style>
