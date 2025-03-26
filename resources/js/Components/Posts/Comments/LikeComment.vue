<template>
    <div>
        <button @click="likeComment" v-if="!liked" class="flex items-center gap-1 text-sm hover:text-blue-500 transition">
            <i class="fa-regular fa-thumbs-up"></i> {{ $t("Like") }}
        </button>
        <button @click="likeComment" v-else class="flex items-center gap-1 text-sm hover:text-blue-500 transition">
            <i class="fa-solid fa-thumbs-up text-blue-500"></i> {{ $t("Liked") }}
        </button>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import fetchFunction from "@/Utl/fetchFunction";

const { comment } = defineProps({
    comment: {
        type: Object,
        required: true,
    },
})

const liked = ref(comment.liked);

const likeComment = async () => {
    try {
        liked.value = !liked.value;
        await fetchFunction.post(route("comments.like", comment.id));
        router.reload(['posts']);
    } catch (error) {
        liked.value = !liked.value;
    }
};
</script>