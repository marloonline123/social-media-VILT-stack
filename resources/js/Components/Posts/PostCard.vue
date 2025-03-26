<template>
  <div class="bg-white dark:bg-slate-700 shadow-md rounded-md p-3">
    <div class="flex items-center justify-between">

      <PostWritter :post="post" />

      <div>
        <PostOptions :post="post" />
      </div>
    </div>

    <div class="mt-5">
      
      <PostContent :post="post" />
      <div v-if="post.likes_count > 0" class="mt-3 flex items-center gap-1">
        <i class="fa-solid fa-heart text-rose-600"></i>
        <span v-if="post.likes_count == 1">{{ (post.liked ? 'You ' : 'One person') }} liked this post</span>
        <span v-else>{{ (post.liked ? 'You and ' : '') + (post.likes_count - 1) + ((post.likes_count - 1) > 1 ? ' others' : ' person') }} liked this post</span>
      </div>

      <!-- Action Buttons -->
      <PostButtonsAction :post="post" />
    </div>

    <div>
      <PostComments :post="post" />
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import PostComments from "./Comments/PostComments.vue";
import PostOptions from "./PostOptions.vue";
import PostButtonsAction from "./PostButtonsAction.vue";
import dayjs from "dayjs";
import PostWritter from "./PostWritter.vue";
import { provide } from "vue";
import PostContent from "./PostContent.vue";

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