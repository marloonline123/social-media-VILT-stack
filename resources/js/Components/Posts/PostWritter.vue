<template>
  <div class="flex items-center gap-1">
    <div>
      <img class="w-12 h-12 rounded-full" :src="post.user.avatar" alt="" />
    </div>
    <div>
      <div class="flex items-center gap-[2px]">
        <div v-if="post.postable_type == 'group'">
          <Link :href="route('groups.show', post.postable.slug)" class="text-sm">{{
            post.postable.name
          }}</Link>
          <span class="text-xm">&gt;</span>
        </div>
        <div v-if="post.postable_type == 'page'">
          <Link :href="route('pages.show', post.postable.username)" class="text-sm">{{
            post.postable.name
          }}</Link>
          <span class="text-xm">&gt;</span>
        </div>
        <Link
          :href="route('profile.show', post.user.username)"
          class="text-sm hover:text-blue-600 dark:hover:text-blue-400 duration-150 hover:underline"
        >
          {{ post.user.name }}
        </Link>
      </div>
      <small class="text-[10px] block">{{ post.created_at }}</small>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import dayjs from "dayjs";

const { post } = defineProps({
  post: {
    type: Object,
    required: true,
  },
});
</script>
