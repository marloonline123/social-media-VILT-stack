<template>
  <Link
    :href="route('profile.show', user.username)"
    class="p-2 hover:bg-blue-100 dark:hover:bg-slate-600 block duration-200 rounded-md"
  >
    <div class="flex items-center gap-2">
      <div>
        <Image
          class="w-12 h-12 rounded-full object-cover"
          :src="user.avatar"
          alt="user Avatar"
        />
      </div>
      <div class="text-sm">
        <h4 class="font-bold">{{ trancuteText(user.name, 20) }}</h4>
        <p class="text-xs">@{{ trancuteText(user.username) }}</p>
        <p class="text-xs">{{ trancuteText(user.bio) }}</p>
      </div>
    </div>
  </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Image from "../Image.vue";

defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const trancuteText = (text, limit = 30) => {
  if (text && text.length > limit) {
    return text.slice(0, limit) + "...";
  }
  return text;
};
</script>
