<template>
    <div>
        <ValidationError :for="$page.props.errors[`attachments.${index}`]" />

        <div v-if="attachment.type.includes('image')"
            class="w-full border border-slate-200 relative dark:border-slate-600 rounded-md flex items-center justify-center">
            <button @click="$emit('removeAttachment', attachment)"
                class="absolute top-2 right-2 z-20 bg-white shadow-md rounded-full w-[25px] h-[25px] grid place-items-center cursor-pointer hover:bg-slate-100 duration-150">
                <i class="fa-solid fa-times cursor-pointer"></i>
            </button>
            <Image :src="attachment.preview" alt="Attachment Preview" class="w-full object-cover rounded-md"
                :class="{ 'h-[180px]': attachments.length > 1, 'h-[400px]': attachments.length == 1 }" />
        </div>

        <div v-if="attachment.type.includes('video')"
            class="w-full border relative group border-slate-200 dark:border-slate-600 rounded-md flex items-center justify-center">
            <button @click="$emit('removeAttachment', attachment)"
                class="absolute top-2 right-2 z-20 bg-white shadow-md rounded-full w-[25px] h-[25px] grid place-items-center cursor-pointer hover:bg-slate-100 duration-150">
                <i class="fa-solid fa-times cursor-pointer"></i>
            </button>
            <Video :src="attachment.preview" alt="Attachment Preview" class="w-full rounded-md"
                :class="{ 'h-[180px]': attachments.length > 1, 'h-[400px]': attachments.length == 1 }"></Video>
        </div>
    </div>
</template>

<script setup>
import Image from '@/Components/Image.vue';
import ValidationError from '@/Components/ValidationError.vue';
import Video from '@/Components/Video.vue';

const props = defineProps({
    attachment: {
        type: Object,
        required: true
    },
    attachments: {
        type: Array,
        required: true
    },
    index: {
        type: Number,
        required: true
    }
})

defineEmits(['removeAttachment'])


</script>