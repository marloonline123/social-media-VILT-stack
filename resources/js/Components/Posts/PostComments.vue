<template>
  <div class="mt-5">
    <Title class="text-lg text-blue-500">Comments</Title>
    <div class="flex flex-col gap-2">
      <CommentCard />
      <CommentCard />
      <CommentCard />
    </div>

    <div class="mt-3">
      <CommentBox />
    </div>
  </div>
</template>

<script setup>
import CommentCard from "./CommentCard.vue";
import CommentBox from "./CommentBox.vue";
import Title from "../Title.vue";
</script>
