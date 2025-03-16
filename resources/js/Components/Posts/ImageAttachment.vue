<template>
    <div>
        <Image @click="openAttachmentPreview(index)"
            class="w-full object-cover cursor-pointer hover:opacity-90 duration-200 rounded"
            :class="{ 'h-[150px] md:h-[200px]': attachments.length > 1 }" :src="attachment.preview" alt="" />
    </div>
</template>

<script setup>
import Image from '../Image.vue';

defineProps({
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
    },
    openAttachmentPreview: {
        type: Function,
        required: true
    }
})
</script>