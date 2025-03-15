<template>
    <img :src="src" loading="lazy"/>
</template>

<script setup>
defineProps({
    src: {
        type: String,
        required: true
    }
})
</script>