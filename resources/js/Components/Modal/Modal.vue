<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';
import Card from '../Card.vue';
import Title from '../Title.vue';
import IconButton from '../IconButton.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: '',
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);
const dialog = ref();
const showSlot = ref(props.show);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = 'hidden';
            showSlot.value = true;

            dialog.value?.showModal();
        } else {
            document.body.style.overflow = '';

            setTimeout(() => {
                dialog.value?.close();
                showSlot.value = false;
            }, 200);
        }
    },
);

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape') {
        e.preventDefault();

        if (props.show) {
            close();
        }
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);

    document.body.style.overflow = '';
});

const maxWidthClass = computed(() => {
    return {
        sm: 'sm:max-w-sm',
        md: 'sm:max-w-md',
        lg: 'sm:max-w-lg',
        xl: 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
    }[props.maxWidth];
});
</script>

<template>
    <dialog class="z-50 m-0 min-h-full min-w-full overflow-y-auto bg-transparent backdrop:bg-transparent" ref="dialog">
        <div class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0" scroll-region>
            <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0"
                enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <div v-show="show" class="fixed inset-0 transform transition-all" @click.stop="close">
                    <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900" />
                </div>
            </Transition>

            <Transition enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div v-show="show"
                    class="mb-6 transform overflow-hidden z-40 rounded-lg bg-white shadow-xl transition-all sm:mx-auto sm:w-full dark:bg-gray-800"
                    :class="maxWidthClass" @click.stop>
                    <Card style="padding: 0;" class="p-0 dark:text-slate-100">
                        <div
                            class="py-3 px-2 w-full bg-slate-200 dark:bg-slate-600 shadow border-2 dark:border-slate-500 flex justify-between items-center">
                            <Title v-if="title">{{ title }}</Title>
                            <IconButton class="ml-auto hover:bg-slate-300 dark:hover:bg-slate-500" @click.stop="close" icon="fa-solid fa-times" />
                        </div>

                        <div class="border-x-2 py-3 dark:border-slate-500">
                            <slot />
                        </div>

                        <div class="py-3 px-2 bg-slate-100 dark:bg-slate-600 shadow border-2 dark:border-slate-500">
                            <slot name="footer" />
                        </div>
                    </Card>
                    <!-- <slot v-if="showSlot" /> -->
                </div>
            </Transition>
        </div>
    </dialog>
</template>
