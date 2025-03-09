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
      <div class="mt-3 flex items-center gap-1">
        <i class="fa-regular fa-heart"></i>
        <span>Jhon and other 2 liked this post</span>
      </div>

      <!-- Action Buttons -->
      <PostButtonsAction />
    </div>

    <div>
      <PostComments />
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import PostComments from "./PostComments.vue";
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