<template>
  <div
    class="bg-white relative p-4 flex flex-col items-center border-2 rounded-lg transition-all duration-300 hover:shadow-xl"
  >
    <div class="absolute top-2 right-2">
      <MemberCardOptions
        v-if="group.joined && group.is_admin && group.user_id !== member.id"
        :member="member"
      />
    </div>
    <div class="relative">
      <img
        class="w-16 h-16 object-cover rounded-full border-2 border-gray-300"
        :src="member.avatar"
        :alt="member.name"
      />
    </div>

    <div class="text-center mt-3">
      <Link :href="route('profile.show', member.username)">
        <h2 class="text-lg font-semibold text-gray-800">{{ member.name }}</h2>
      </Link>
    </div>

    <span
      class="mt-2 px-3 py-1 text-xs font-semibold rounded-full capitalize"
      :class="getRoleBadge(member.role)"
    >
      {{ member.role }}
    </span>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import MemberCardOptions from "./MemberCardOptions.vue";

defineProps({
  member: {
    type: Object,
    required: true,
  },
  group: {
    type: Object,
    required: true,
  },
});

const getRoleBadge = (role) => {
  switch (role) {
    case "admin":
      return "bg-red-100 text-red-600 border border-red-400";
    case "moderator":
      return "bg-blue-100 text-blue-600 border border-blue-400";
    case "member":
      return "bg-green-100 text-green-600 border border-green-400";
    default:
      return "bg-gray-100 text-gray-600 border border-gray-400";
  }
};
</script>
