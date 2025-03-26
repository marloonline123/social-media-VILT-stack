<template>
    <div v-if="comment.replies_count > 0">
        <p @click="toggleReplies" class="text-xs text-blue-700 hover:text-blue-500 cursor-pointer">
        Has {{ comment.replies_count }} {{ comment.replies_count > 1 ? "replies" : "reply" }}</p>
    </div>
</template>

<script setup>

defineProps({
    comment: {
        type: Object,
        required: true
    },
    toggleReplies: {
        type: Function,
        required: true
    }
})

</script>