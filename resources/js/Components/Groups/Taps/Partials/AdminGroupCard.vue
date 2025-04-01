<template>
  <div class="flex items-center gap-3">
    <!-- Avatar -->
    <img
      :src="admin.avatar"
      class="w-10 h-10 rounded-full border-2 border-indigo-500 shadow-sm"
      :alt="admin.name"
    />

    <!-- Admin Info -->
    <Link
      :href="route('profile.show', admin.username)"
      class="flex flex-col text-gray-700 hover:text-indigo-600 transition duration-300"
    >
      <h3 class="text-base font-semibold">{{ admin.name }}</h3>
      <p class="text-sm text-gray-500">@{{ admin.username }}</p>
    </Link>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  admin: {
    type: Object,
    required: true,
  },
});
</script>
