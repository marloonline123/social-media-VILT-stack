<template>
  <div
    class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-md rounded-xl px-5 py-2 transition-all hover:shadow-lg">
    <div class="flex items-start gap-2">
      <!-- Avatar -->
      <div class="h-12 w-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-300 dark:border-slate-600">
        <img class="w-full h-full object-cover" :src="'/storage/' + comment.user.avatar" alt="User avatar" />
      </div>

      <!-- Post Content -->
      <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between">
          <div class="flex w-full items-center justify-between">
            <div class="flex items-center gap-2">
              <Link :href="route('profile.show', comment.user.username)"
                class="text-base font-semibold text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400 transition">
              {{ comment.user.name }}
              </Link>
              <span class="text-xs text-gray-500 dark:text-slate-400">• {{ comment.created_at }}</span>
            </div>
            <CommentOptions v-if="comment.user?.id === $page.props.auth?.user?.id" :comment="comment" />
          </div>
        </div>
        <p class="text-sm text-gray-800 dark:text-slate-200 leading-relaxed">
          {{ comment.body }}
        </p>

        <!-- Action Buttons -->
        <div class="mt-3 flex items-center gap-4 text-gray-500 dark:text-slate-400">
          <LikeComment :comment="comment" />
          <button @click="openReply = !openReply"
            class="flex items-center gap-1 text-sm hover:text-blue-500 transition">
            <i class="fa-regular fa-comment"></i> {{ $t("Reply") }}
          </button>
        </div>

        <RepliesCountToggle :comment="comment" :toggleReplies="toggleReplies" />

        <div v-if="openReply">
          <CommentReply :comment="comment" @close-reply="openReply = false" />
        </div>

        <div v-show="showReplies" class="mt-3">
          <RepliesList :comment="comment" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import LikeComment from "./LikeComment.vue";
import { ref } from "vue";
import CommentReply from "./CommentReply.vue";
import RepliesList from "./RepliesList.vue";
import CommentOptions from "./CommentOptions.vue";
import RepliesCountToggle from "./RepliesCountToggle.vue";

const { comment } = defineProps({
  comment: {
    type: Object,
    required: true,
  },
})

const openReply = ref(false);
const showReplies = ref(false);

const toggleReplies = () => {
  showReplies.value = !showReplies.value;
}

</script>
