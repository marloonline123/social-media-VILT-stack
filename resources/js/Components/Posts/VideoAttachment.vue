<template>
    <div v-if="attachment.mime.includes('video')">
        
        <Video class="w-full max-h-[400px] bg-black rounded" :class="{ 'h-[150px] md:h-[200px]': attachments.length > 1 }"
            :src="attachment.preview" alt=""  />
    </div>
</template>

<script setup>
import Video from '../Video.vue';


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
    }
})
</script>