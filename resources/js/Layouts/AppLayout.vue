<script setup>
import Toast from "@/Components/Toast/Toast.vue";
import Header from "./Partials/Header.vue";
import { useToast } from "@/Utl/useToast";
import { provide, ref } from "vue";

// const { showToast } = useToast();

const toasts = ref([]);

const showToast = (message, type = "success") => {
  const id = Date.now();
  toasts.value.unshift({ id, message, type });

  // Remove the toast after 3 seconds
  setTimeout(() => {
    toasts.value = toasts.value.filter((toast) => toast.id !== id);
  }, 3000);
};

// Provide `showToast` globally
provide("toast", showToast);
</script>

<template>
  <div class="mt-[70px]">
    <Header />
    
    <main class="p-3 min-h-[calc(100vh-70px)]">
      <slot />
    </main>

    <Toast :toasts="toasts"/>
  </div>
</template>
