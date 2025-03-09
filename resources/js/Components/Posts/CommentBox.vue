<template>
  <div
    class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-md rounded-xl p-4 transition-all hover:shadow-lg"
  >
    <div class="flex items-start gap-3">
      <!-- Avatar -->
      <div
        class="h-10 w-10 rounded-full overflow-hidden flex-shrink-0 border border-gray-300 dark:border-slate-600"
      >
        <img
          class="w-full h-full object-cover"
          src="https://media.istockphoto.com/id/183412466/photo/eastern-bluebirds-male-and-female.jpg?s=612x612&w=0&k=20&c=6_EQHnGedwdjM9QTUF2c1ce7cC3XtlxvMPpU5HAouhc="
          alt="User avatar"
        />
      </div>

      <!-- Comment Input -->
      <div class="flex w-full gap-1 items-center">
        <textarea
          v-model="comment"
          :placeholder="$t('Write a comment...')"
          class="flex-grow text-sm px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900 dark:text-white resize-none transition"
          rows="2"
        ></textarea>

        <div class="flex items-center mt-2">
          <IconButton
            icon="fa-solid fa-paper-plane"
            @click="postComment"
            :disabled="!comment.trim()"
            class=""
          >
          </IconButton>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import IconButton from "../IconButton.vue";

const comment = ref("");

const postComment = () => {
  if (comment.value.trim()) {
    console.log("Comment Posted:", comment.value);
    comment.value = ""; // Clear after posting
  }
};
</script>
