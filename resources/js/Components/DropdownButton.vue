<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    icon: {
        type: String,
        required: false,
    },
});
</script>

<template>
    <button
        class="w-full flex gap-2 items-center px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none dark:text-gray-300 dark:hover:bg-gray-800 dark:focus:bg-gray-800">
        <i v-if="icon" :class="icon"></i>
        <slot />
    </button>
</template>
