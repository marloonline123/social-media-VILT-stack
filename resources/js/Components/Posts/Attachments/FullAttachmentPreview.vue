<template>
    <div>
        <div class="w-full h-full fixed top-0 left-0 z-50">
            <!-- Overlay -->
            <div class="w-full h-full absolute top-0 left-0 bg-slate-900/90" @click="closeAttachmentPreview">
            </div>

            <!-- Close Button -->
            <div>
                <IconButton icon="fa-solid fa-times" @click="closeAttachmentPreview"
                    class="absolute top-3 right-3 z-[70] text-2xl text-white hover:text-slate-900" />
            </div>

            <!-- Centered Container -->
            <div class="absolute z-[50] top-0 left-0 flex justify-center items-center w-full h-full">
                <div class="relative max-w-full max-h-full flex justify-center items-center">
                    <!-- Image Preview -->
                    <div v-if="attachments[activeAttachment]"
                        :key="attachments[activeAttachment].id"
                        class="w-full h-[90vh] flex justify-center items-center">
                        <Image v-if="attachments[activeAttachment].type.includes('image')" :src="attachments[activeAttachment].preview" alt="Attachment Preview"
                            class="max-w-full max-h-full object-contain" />
                        <Video v-if="attachments[activeAttachment].type.includes('video')" :src="attachments[activeAttachment].preview" alt="Attachment Preview"
                            class="max-w-full max-h-full"></Video>
                    </div>
                </div>
            </div>


            <!-- Navigation Buttons -->
            <div v-show="attachments.length > 1">
                <IconButton @click="prevBtn" icon="fa-solid fa-arrow-left"
                    class="absolute top-1/4 md:top-1/2 left-5 transform md:-translate-y-1/2 text-xl text-white hover:text-slate-900 dark:hover:bg-slate-200 z-[70]" />
                <IconButton @click="nextBtn" icon="fa-solid fa-arrow-right"
                    class="absolute top-1/4 md:top-1/2 right-5 transform md:-translate-y-1/2 text-xl text-white hover:text-slate-900 dark:hover:bg-slate-200 z-[70]" />
            </div>
        </div>
    </div>
</template>


<script setup>
import IconButton from '@/Components/IconButton.vue';
import Image from '@/Components/Image.vue';
import Video from '@/Components/Video.vue';
import { ref } from 'vue';

const props = defineProps({
    attachments: {
        type: Array,
        required: true
    },
    closeAttachmentPreview: {
        type: Function,
        required: true
    },
    activeAttachmentIndex: {
        type: Number,
        required: true
    }
})

const activeAttachment = ref(props.activeAttachmentIndex);
const nextBtn = () => {
    if (activeAttachment.value < props.attachments.length - 1) {
        activeAttachment.value++;
    } else {
        activeAttachment.value = 0;
    }
};

const prevBtn = () => {
    if (activeAttachment.value > 0) {
        activeAttachment.value--;
    } else {
        activeAttachment.value = props.attachments.length - 1;
    }
};
</script>