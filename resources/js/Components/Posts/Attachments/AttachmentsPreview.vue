<template>
    <div>
        <div class="pt-8 relative">
            <div class="mt-4 px-3 grid grid-cols-1 gap-2" :class="{ 'grid-cols-2': allAttachments.length > 1 }"
                v-if="allAttachments.length > 0">
                <AttachmentItem v-for="(attachment, index) in allAttachments" :attachment="attachment" :attachments="allAttachments" :index="index" @removeAttachment="$emit('removeAttachment', attachment)" :key="index" />
            </div>

            <div class="absolute top-2 right-5">
                <AttachmentButton @handleFileUpload="handleFileUpload" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import AttachmentButton from './AttachmentButton.vue';
import AttachmentItem from './AttachmentItem.vue';
import { all } from 'axios';

const emit = defineEmits(['handleAttachments', 'removeAttachment']);

const props = defineProps({
    attachments: {
        type: Array,
        default: []
    },
    uploadedAttachments: {
        type: Array,
        default: []
    }
})

const allAttachments = computed(() => [...props.uploadedAttachments, ...props.attachments]);

const handleFileUpload = (event) => {
    if (!event.target.files.length) return;
    const files = Array.from(event.target.files);
    files.forEach((file) => {
        file.preview = URL.createObjectURL(file);
    });
    
    emit('handleAttachments', [...files]);
};


</script>