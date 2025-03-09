<template>
  <div
    class="bg-white dark:bg-slate-700 shadow-md p-5 w-1/4 overflow-y-auto rounded-md h-[100vh-70px] fixed top-[80px] bottom-3 left-3 rtl:right-3"
  >
    <div>
      <div>
        <LeftColumnMenu />
      </div>
      <div>
        <PagesYouLiked />
      </div>
    </div>
  </div>
</template>

<script setup>
import LeftColumnMenu from "../Sections/LeftColumnMenu.vue";
import PagesYouLiked from "../Sections/PagesYouLiked.vue";
</script>
