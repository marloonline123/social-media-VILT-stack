<template>
    <video :src="src" :controls="controls" class="bg-black"></video>
</template>

<script setup>
defineProps({
    src: {
        type: String,
        required: true
    },
    controls: {
        type: Boolean,
        default: true
    }
})
</script>