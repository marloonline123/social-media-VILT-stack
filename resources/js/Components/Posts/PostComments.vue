<template>
  <div class="mt-5">
    <div v-if="post.comments.length > 0">
      <Title class="text-lg text-blue-500">Comments</Title>
      <div class="flex flex-col gap-2">
        <CommentCard v-for="comment in post.comments" :key="comment.id" :comment="comment" />
      </div>
    </div>

    <div class="mt-3">
      <CommentBox :post="post" />
    </div>
  </div>
</template>

<script setup>
import CommentCard from "./Comments/CommentCard.vue";
import CommentBox from "./Comments/CommentBox.vue";
import Title from "../Title.vue";

defineProps({
  post: {
    type: Object,
    required: true
  }
})

</script>
