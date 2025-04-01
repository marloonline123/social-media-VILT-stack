<template>
  <div
    class="bg-white dark:bg-slate-700 shadow-md rounded-md p-5 h-[100vh-70px] md:w-1/3 lg:w-1/4 overflow-y-auto fixed top-[80px] bottom-3 ltr:right-3 rtl:left-3"
  >
    <div>
      <div>
        <FollowersSection :followers="followers" />
      </div>
      <div>
        <GroupsSection :groups="groups" />
      </div>
    </div>
  </div>
</template>

<script setup>
import FollowersSection from "../Sections/FollowersSection.vue";
import GroupsSection from "../Groups/GroupsSection.vue";

defineProps({
  groups: {
    type: Array,
    required: true,
  },
  followers: {
    type: Array,
    required: true,
  },
});
</script>
