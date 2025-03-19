<template>
    <div class="flex items-center justify-center flex-1 relative">
        <!-- Like Button -->
        <button @click="likePost" :class="{ 'hidden': liked }"
            class="like-btn group text-2xl flex items-center justify-center gap-1.5 w-full hover:bg-slate-100 dark:hover:bg-slate-600 px-2 py-1.5 rounded-md transition-all duration-200">
            <i class="fa-regular fa-heart py-1 transition-colors"></i>
            <span
                class="text-xs font-medium text-slate-600 dark:text-slate-300 group-hover:text-slate-800 dark:group-hover:text-slate-100">
                Like
            </span>
        </button>

        <!-- Liked Button -->
        <button @click="likePost" :class="{ 'hidden': !liked }"
            class="liked-btn group text-2xl flex items-center justify-center gap-1.5 w-full hover:bg-slate-100 dark:hover:bg-slate-600 px-2 py-1.5 rounded-md transition-all duration-200">
            <i class="fa-solid fa-heart py-1 transition-colors text-rose-500"></i>
            <span
                class="text-xs font-medium text-slate-600 dark:text-slate-300 group-hover:text-slate-800 dark:group-hover:text-slate-100">
                Liked
            </span>
        </button>
    </div>
</template>

<script setup>
import fetchFunction from '@/Utl/fetchFunction';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const { post } = defineProps({
    post: {
        type: Object,
        required: true,
    },
});

const liked = ref(post.liked);

const likePost = async () => {
    try {
        liked.value = !liked.value;
        await fetchFunction.post(route("posts.like", post.id));
        router.reload(['posts']);
    } catch (error) {
        liked.value = !liked.value;
    }
};
</script>

<style scoped>
/* Like Button Animation */
.like-btn {
    animation: fadeInScale 0.2s ease-in-out;
}

/* Liked Button Animation */
.liked-btn {
    animation: fadeInScale 0.2s ease-in-out;
}

/* Smooth Fade and Scale */
@keyframes fadeInScale {
    0% {
        opacity: 0;
        transform: scale(0.8);
    }

    50% {
        opacity: .5;
        transform: scale(1.3);
    }

    100% {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
