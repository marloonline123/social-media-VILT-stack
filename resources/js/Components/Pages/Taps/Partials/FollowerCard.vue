<template>
  <div
    class="bg-white relative p-5 flex flex-col items-center border border-gray-200 rounded-lg shadow-sm transition-all duration-300 hover:shadow-lg"
  >
    <!-- Profile Image -->
    <div class="relative">
      <img
        class="w-20 h-20 object-cover rounded-full border-4 border-gray-200 shadow-sm"
        :src="follower.avatar"
        :alt="follower.name"
      />
    </div>

    <!-- Name & Profile Link -->
    <div class="text-center mt-4">
      <Link :href="route('profile.show', follower.username)" class="hover:underline">
        <h2 class="text-lg font-bold text-gray-800">{{ follower.name }}</h2>
        <p class="text-sm text-gray-500">@{{ follower.username }}</p>
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";

// Props
const props = defineProps({
  page: { type: Object, required: true },
  follower: { type: Object, required: true },
});

const toggleFollow = () => {
  router.post(
    route("pages.follow-toggle", props.page.id),
    {},
    {
      preserveScroll: true,
    }
  );
};
</script>
