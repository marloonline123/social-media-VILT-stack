<template>
    <div class="fixed top-[80px] right-5">
        <TransitionGroup name="toast" tag="div">
            <div v-for="toast in toasts" :key="toast.id"
                class="z-50 min-w-[250px] text-white px-4 py-2 rounded-md shadow-lg mb-3"
                :class="{ 
                    'bg-green-500': toast.type === 'success', 
                    'bg-red-500': toast.type === 'error',
                    'bg-blue-500': toast.type === 'info',
                }">
                <div class="flex items-center">
                    <i v-if="toast.type === 'success'" class="fa-solid fa-check-circle text-xl"></i>
                    <i v-if="toast.type === 'error'" class="fa-solid fa-circle-xmark text-xl"></i>
                    <i v-if="toast.type === 'info'" class="fa-solid fa-circle-info text-xl"></i>
                    <p class="ml-2">{{ toast.message }}</p>
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<script setup>
import { ref, provide } from "vue";
defineProps({
    toasts: {
        type: Array,
        default: () => [],
    },
});


</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
    @apply transition-all ease-in-out duration-200;
}

.toast-enter-from,
.toast-leave-to {
    @apply opacity-0 translate-x-10;
}

.toast-enter-to,
.toast-leave-from {
    @apply opacity-100 translate-x-0;
}
</style>
