<script setup>
import { onMounted, ref } from "vue";

const model = defineModel({
  type: String,
  required: true,
});

defineProps({
  icon: {
    type: String,
    default: null,
  },
  resize: {
    type: Boolean,
    default: false,
  },
});

const input = ref(null);

onMounted(() => {
  if (input.value?.hasAttribute("autofocus")) {
    input.value.focus();
  }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
  <div class="relative bg-transparent border-none p-0">
    <textarea
      rows="3"
      ref="input"
      v-model="model"
      class="rounded-md border-gray-300 shadow-sm bg-slate-100 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-slate-800 dark:text-gray-300 dark:focus:border-blue-600 dark:focus:ring-blue-600"
      :class="{ 'pr-7': icon, 'resize-none': !resize, resize: resize }"
      v-bind="$attrs"
    ></textarea>
    <i class="absolute top-3 right-2" v-if="icon" :class="icon"></i>
  </div>
</template>
