<template>
    <div>
        <div class="pt-8 relative">
            <div class="mt-4 px-3 grid grid-cols-1 gap-2" :class="{ 'grid-cols-2': allAttachments.length > 1 }"
                v-if="allAttachments.length > 0">
                <AttachmentItem v-for="(attachment, index) in allAttachments" :attachment="attachment" :attachments="allAttachments" :index="index" :delete-attachment="deleteAttachment" :key="index" />
            </div>

            <div class="absolute top-2 right-5">
                <AttachmentButton @handleFileUpload="handleFileUpload" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onUpdated, ref, watch } from 'vue';
import AttachmentButton from './AttachmentButton.vue';
import AttachmentItem from './AttachmentItem.vue';
import { all } from 'axios';

const emit = defineEmits(['handleAttachments']);

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


// const allAttachments = ref([...props.uploadedAttachments, ...props.attachments]);

const allAttachments = computed(() => [...props.uploadedAttachments, ...props.attachments]);

console.log('allAttachments when created', allAttachments.value);


// watch(props.uploadedAttachments, (newData) => {
//     console.log('new All Attachments', newData);
//     allAttachments.value = [...newData, ...props.attachments];
//     console.log('allAttachments', allAttachments.value);
    
// })

const handleFileUpload = (event) => {
    if (!event.target.files.length) return; // Prevent adding empty files
    const files = Array.from(event.target.files);
    files.forEach((file) => {
        file.preview = URL.createObjectURL(file);
        allAttachments.value.push(file);
    });
    // console.log("Attachments updated:", [...attachments.value, ...files]);
    
    emit('handleAttachments', [...files]);
};

const deleteAttachment = (index) => {
    attachments.value.splice(index, 1);
};

</script>