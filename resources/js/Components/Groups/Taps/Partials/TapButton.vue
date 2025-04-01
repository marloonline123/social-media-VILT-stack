<template>
  <button
    class="px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600"
    :class="{
      'border-b-2 border-b-blue-500 text-blue-500': activeTap === text,
    }"
  >
    <slot />
  </button>
</template>

<script setup>
defineProps({
  activeTap: {
    type: String,
    required: true,
  },
  text: {
    type: String,
    required: true,
  },
});
</script>
