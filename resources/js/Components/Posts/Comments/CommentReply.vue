<template>
  <div>
    <div class="flex w-full gap-1 items-center mt-2">
      <form class="flex w-full gap-1 items-center" @submit.prevent="reply">
        <textarea
          :placeholder="$t('Write a reply...')"
          v-model="form.body"
          class="flex-grow text-sm px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-900 dark:text-white resize-none transition"
          rows="1"
        ></textarea>

        <div class="flex items-center">
          <IconButton type="submit" icon="fa-solid fa-paper-plane" />
        </div>
      </form>
    </div>
    <ValidationError :for="form.errors.body" class="mx-1" />
  </div>
</template>

<script setup>
import IconButton from "@/Components/IconButton.vue";
import ValidationError from "@/Components/ValidationError.vue";
import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { useStore } from "vuex";

const { comment } = defineProps({
  comment: {
    type: Object,
    required: true,
  },
});
const emit = defineEmits(["close-reply"]);
const store = useStore();
const isLoading = ref(false);
const form = useForm({
  body: "",
});

const reply = async () => {
  if (form.body.trim() === "") {
    form.errors.body = "Reply cannot be empty.";
    return;
  }
  isLoading.value = true;
  await store.dispatch("Posts/storeCommentReply", { id: comment.id, body: form.body });
  form.reset();
  emit("close-reply");
  isLoading.value = false;
};
</script>
