<template>
  <Link
    :href="link"
    class="p-2 hover:bg-blue-100 dark:hover:bg-slate-600 block duration-200 rounded-md"
  >
    <div class="flex items-center gap-2">
      <div>
        <img class="w-12 h-12 rounded-full object-cover" :src="image" alt="user Avatar" />
      </div>
      <div class="text-sm">
        <h4 class="font-bold">{{ title }}</h4>
        <p class="text-xs">{{ desc }}</p>
      </div>
    </div>
  </Link>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps({
  title: {
    type: String,
  },
  desc: {
    type: String,
  },
  link: {
    type: String,
  },
  image: {
    type: String,
  },
});
</script>
