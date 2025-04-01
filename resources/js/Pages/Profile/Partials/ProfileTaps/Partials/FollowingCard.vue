<template>
  <div
    class="bg-white relative p-5 flex flex-col items-center border border-gray-200 rounded-lg shadow-sm transition-all duration-300 hover:shadow-lg"
  >
    <!-- Profile Image -->
    <div class="relative">
      <img
        class="w-20 h-20 object-cover rounded-full border-4 border-gray-200 shadow-sm"
        :src="following.avatar"
        :alt="following.name"
      />
    </div>

    <!-- Name & Profile Link -->
    <div class="text-center mt-4">
      <Link :href="route('profile.show', following.username)" class="hover:underline">
        <h2 class="text-lg font-bold text-gray-800">{{ following.name }}</h2>
      </Link>
    </div>

    <!-- Follow/Unfollow Button -->
    <button
      @click="toggleFollow"
      class="mt-4 px-4 py-2 w-full rounded-lg text-sm font-semibold transition-all duration-200"
      :class="
        following.isFollowing
          ? 'bg-gray-300 text-gray-700 hover:bg-gray-400'
          : 'bg-blue-500 text-white hover:bg-blue-600'
      "
    >
      {{ following.isFollowing ? "Unfollow" : "Follow Back" }}
    </button>
  </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";

// Props
const props = defineProps({
  user: { type: Object, required: true },
  following: { type: Object, required: true },
});

// Reactive state to check if user follows the following
// const isFollowing = ref(props.following.isFollowing);

// Toggle follow state (dummy logic for now)
const toggleFollow = () => {
  router.post(
    route("profile.follow-toggle", props.following.username),
    {},
    {
      preserveScroll: true,
    }
  );
};
</script>
