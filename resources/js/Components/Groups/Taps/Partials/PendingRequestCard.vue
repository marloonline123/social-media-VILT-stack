<template>
  <div
    class="bg-white p-5 flex flex-col items-center shadow-lg rounded-lg transition-all duration-300 hover:shadow-xl"
  >
    <div class="relative">
      <img
        class="w-20 h-20 object-cover rounded-full border-4 border-gray-200"
        :src="request.avatar"
        :alt="request.name"
      />
    </div>

    <div class="text-center mt-4">
      <Link :href="route('profile.show', request.username)">
        <h2 class="text-lg font-semibold text-gray-800">{{ request.name }}</h2>
      </Link>
    </div>

    <div class="mt-4 flex gap-3 w-full">
      <button
        @click="approveRequest(index)"
        class="w-full px-4 py-2 bg-gradient-to-r from-blue-400 to-sky-500 text-white text-sm font-semibold rounded-md shadow-md hover:from-blue-500 hover:to-sky-600"
      >
        Approve
      </button>
      <button
        @click="rejectRequest(index)"
        class="w-full px-4 py-2 bg-gradient-to-r from-red-400 to-rose-500 text-white text-sm font-semibold rounded-md shadow-md hover:from-red-500 hover:to-rose-600"
      >
        Reject
      </button>
    </div>
  </div>
</template>

<script setup>
import { useToast } from "@/Utl/useToast";
import { Link, router } from "@inertiajs/vue3";

const { showToast } = useToast();
const { group, request } = defineProps({
  group: {
    type: Object,
    required: true,
  },
  request: {
    type: Object,
    required: true,
  },
});

const approveRequest = () => {
  router.post(
    route("groups.approve", group.slug),
    {
      user_id: request.id,
    },
    {
      onSuccess: () => {
        showToast(`${request.name} has been approved!`);
      },
    }
  );
};
const rejectRequest = () => {
  router.post(
    route("groups.reject", group.slug),
    {
      user_id: request.id,
    },
    {
      onSuccess: () => {
        showToast(`${request.name} has been rejected!`);
      },
    }
  );
};
</script>
