<template>
    <div v-if="for" class="bg-red-100 rounded-md mx-1">
        <p class="p-2 text-red-500">{{ for }}</p>
    </div>
</template>

<script setup>
defineProps({
    for: {
        type: String,
    },
});
</script>