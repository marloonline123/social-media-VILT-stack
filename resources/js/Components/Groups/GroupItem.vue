<template>
  <Link
    :href="route('groups.show', group.slug)"
    class="p-2 hover:bg-blue-100 dark:hover:bg-slate-600 block duration-200 rounded-md"
  >
    <div class="flex items-center gap-2">
      <div>
        <Image
          class="w-12 h-12 rounded-full object-cover"
          :src="group.avatar"
          alt="user Avatar"
        />
      </div>
      <div class="text-sm">
        <h4 class="font-bold">{{ trancuteText(group.name, 20) }}</h4>
        <p class="text-xs">{{ trancuteText(group.about) }}</p>
      </div>
    </div>
  </Link>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import Image from "../Image.vue";

defineProps({
  group: {
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
