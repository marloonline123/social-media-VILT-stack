<template>
  <Link
    :href="route('pages.show', page.username)"
    class="p-2 hover:bg-blue-100 dark:hover:bg-slate-600 block duration-200 rounded-md"
  >
    <div class="flex items-center gap-2">
      <div>
        <img
          class="w-12 h-12 rounded-full object-cover"
          :src="page.avatar"
          alt="user Avatar"
        />
      </div>
      <div class="text-sm">
        <h4 class="font-bold">{{ trancuteText(page.name, 20) }}</h4>
        <p class="text-xs">{{ trancuteText(page.about) }}</p>
      </div>
    </div>
  </Link>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps({
  page: {
    type: Object,
    required: true,
  },
});

const trancuteText = (text, limit = 30) => {
  if (text.length > limit) {
    return text.slice(0, limit) + "...";
  }
  return text;
};
</script>
