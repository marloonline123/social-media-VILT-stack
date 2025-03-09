<template>
    <div class="flex items-center gap-1">
        <div>
            <img class="w-12 h-12 rounded-full"
                src="https://media.istockphoto.com/id/183412466/photo/eastern-bluebirds-male-and-female.jpg?s=612x612&w=0&k=20&c=6_EQHnGedwdjM9QTUF2c1ce7cC3XtlxvMPpU5HAouhc="
                alt="" />
        </div>
        <div>
            <div class="flex items-center gap-[2px]">
                <div v-if="post.group">
                    <Link href="#" class="text-sm">{{ post.group.name }}</Link>
                    <span class="text-xm">&gt;</span>
                </div>
                <Link :href="route('profile.show', post.user.username)"
                    class="text-sm hover:text-blue-600 duration-150 hover:underline">
                {{ post.user.name }}
                </Link>
            </div>
            <small class="text-[10px] block">{{ postDate }}</small>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import dayjs from 'dayjs';

const { post } = defineProps({
    post: {
        type: Object,
        required: true
    }
});

const postDate = dayjs(post.created_at).fromNow();

</script>