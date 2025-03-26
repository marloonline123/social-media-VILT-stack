<template>
  <div class="mt-5">
    <div v-if="post.comments.length > 0">
      <div class="flex justify-between items-center">
        <Title class="text-lg text-blue-500">Comments</Title>
        <p v-if="post.comments_count > 1" class="text-xs">
          {{ post.comments_count }} comments
        </p>
      </div>
      <div>
        <TransitionGroup class="flex flex-col gap-2" name="fade" tag="div">
          <CommentCard
            v-for="comment in post.comments"
            :key="comment.id"
            :comment="comment"
          />
        </TransitionGroup>
      </div>
    </div>

    <div class="mt-3">
      <CommentBox :post="post" />
    </div>
  </div>
</template>

<script setup>
import CommentCard from "./CommentCard.vue";
import CommentBox from "./CommentBox.vue";
import Title from "@/Components/Title.vue";

defineProps({
  post: {
    type: Object,
    required: true,
  },
});
</script>
