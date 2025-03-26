<template>
    <div class="flex flex-col gap-2">
        <CommentReplyCard v-for="comment in comment.replies" :key="comment.id" :comment="comment" />
    </div>
</template>

<script setup>
import CommentReplyCard from './CommentReplyCard.vue';

defineProps({
    comment: {
        type: Object,
        required: true
    }
})
</script>