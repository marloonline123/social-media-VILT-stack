<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    icon: {
        type: String,
        default: null
    },
    link: {
        type: String
    }
})
</script>

<template>
    <li>
        <Link :href="link" v-bind="$attrs" class="p-2 w-full flex gap-2 items-center capitalize leading-snug hover:bg-blue-50 dark:hover:bg-slate-600 rounded-md duration-200">
            <i v-if="icon" :class="icon"></i>
            <slot />
        </Link>
    </li>
</template>