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
      <div class="w-full">
        <div class="flex w-full gap-1 items-center">
          <form class="flex w-full gap-1 items-center" @submit.prevent="postComment">
            <textarea
              v-model="form.body"
              :placeholder="$t('Write a comment...')"
              class="flex-grow text-sm px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900 dark:text-white resize-none transition"
              rows="2"
            ></textarea>

            <div class="flex items-center mt-2">
              <IconButton
                :disabled="isLoading"
                type="submit"
                icon="fa-solid fa-paper-plane"
              />
            </div>
          </form>
        </div>
        <InputError :message="form.errors.body" class="mt-1" />
      </div>
    </div>
  </div>
</template>

<script setup>
import IconButton from "@/Components/IconButton.vue";
import InputError from "@/Components/InputError.vue";
import ValidationError from "@/Components/ValidationError.vue";
import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { useStore } from "vuex";

const { post } = defineProps({
  post: {
    type: Object,
    required: true,
  },
});
const store = useStore();
const isLoading = ref(false);
const form = useForm({
  body: "",
});

const postComment = async () => {
  if (form.body.trim() === "") {
    form.errors.body = "Comment cannot be empty.";
    return;
  }
  isLoading.value = true;
  await store.dispatch("Posts/storeComment", { postId: post.id, body: form.body });
  form.reset();
  isLoading.value = false;
};
</script>
