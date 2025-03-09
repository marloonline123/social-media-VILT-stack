<template>
  <div
    class="bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-700 shadow-md rounded-md px-5 py-2"
  >
    <h2 v-if="title" class="text-4xl text-center font-bold mt-2 mb-5">{{ title }}</h2>
    <slot />
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
  },
});
</script>
