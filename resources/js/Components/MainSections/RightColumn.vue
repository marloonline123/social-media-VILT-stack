<script setup lang="ts">
import FriendsSection from "../Sections/FriendsSection.vue";
import GroupsSection from "../Sections/GroupsSection.vue";
</script>

<template>
  <div
    class="bg-white dark:bg-slate-700 shadow-md rounded-md p-5 h-[100vh-70px] md:w-1/3 lg:w-1/4 overflow-y-auto fixed top-[80px] bottom-3 ltr:right-3 rtl:left-3">
    <div>
      <div>
        <FriendsSection />
      </div>
      <div>
        <GroupsSection />
      </div>
    </div>
  </div>
</template>
