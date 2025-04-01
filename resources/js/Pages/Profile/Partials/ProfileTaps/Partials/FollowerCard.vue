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
      </Link>
    </div>

    <!-- Follow/Unfollow Button -->
    <button
      @click="toggleFollow"
      class="mt-4 px-4 py-2 w-full rounded-lg text-sm font-semibold transition-all duration-200"
      :class="
        follower.isFollowing
          ? 'bg-gray-300 text-gray-700 hover:bg-gray-400'
          : 'bg-blue-500 text-white hover:bg-blue-600'
      "
    >
      {{ follower.isFollowing ? "Unfollow" : "Follow Back" }}
    </button>
  </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";

// Props
const props = defineProps({
  user: { type: Object, required: true },
  follower: { type: Object, required: true },
});

// Reactive state to check if user follows the follower
// const isFollowing = ref(props.follower.isFollowing);

// Toggle follow state (dummy logic for now)
const toggleFollow = () => {
  router.post(
    route("profile.follow-toggle", props.follower.username),
    {},
    {
      preserveScroll: true,
    }
  );
};
</script>
