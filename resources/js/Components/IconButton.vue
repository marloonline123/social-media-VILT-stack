<template>
  <button
    class="bg-transparent cursor-pointer hover:bg-slate-200 dark:hover:bg-slate-600 active:bg-slate-200 dark:active:bg-slate-600 font-bold py-1 px-2 border-none duration-200 rounded-md"
  >
    <div class="flex items-center gap-1">
      <i :class="icon"></i>
      <slot />
    </div>
  </button>
</template>

<script setup>
defineProps({
  icon: {
    type: String,
    required: false,
  },
});
</script>
