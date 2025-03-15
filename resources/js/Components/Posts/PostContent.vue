<template>
    <div>
        <div v-show="isBodyNotEmpty" id="post-body" class="mb-3">
            <p class="" v-html="post.body"></p>
        </div>
        <div v-show="post.attachments.length > 0" class="w-full grid grid-cols-1 gap-1"
            :class="{ 'grid-cols-2': post.attachments.length > 1 }">
            <div v-for="(attachment, index) in post.attachments" :key="post.id">
                <template v-if="post.attachments.length <= 4 || (post.attachments.length > 4 && index < 3)">
                    <ImageAttachment v-if="attachment.mime.includes('image')" :attachment="attachment"
                        :attachments="post.attachments" :key="attachment.id"
                        :openAttachmentPreview="openAttachmentPreview" :index="index" />
                    <VideoAttachment v-if="attachment.mime.includes('video')" :attachment="attachment"
                        :attachments="post.attachments" :key="attachment.id" :index="index" />
                </template>
                <div v-if="post.attachments.length > 4 && index == 3"  @click="openAttachmentPreview(0)"
                    class="bg-slate-900/70 w-full flex justify-center items-center text-white text-xl hover:bg-slate-900/60 cursor-pointer"
                    :class="{ 'h-[150px] md:h-[200px]': post.attachments.length > 1 }">
                    {{ post.attachments.length - 3 }} More
                </div>
            </div>
        </div>
        <FullAttachmentPreview v-if="attachmentPreviewOpened" :activeAttachmentIndex="activeAttachmentIndex"
            :attachments="post.attachments" :closeAttachmentPreview="closeAttachmentPreview" />
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import FullAttachmentPreview from './Attachments/FullAttachmentPreview.vue';
import ImageAttachment from './ImageAttachment.vue';
import VideoAttachment from './VideoAttachment.vue';


const props = defineProps({
    post: {
        type: Object,
        required: true
    }
})

const attachmentPreviewOpened = ref(false);
const activeAttachmentIndex = ref(0);

const openAttachmentPreview = (index) => {
    attachmentPreviewOpened.value = true;
    activeAttachmentIndex.value = index
}

const closeAttachmentPreview = () => {
    attachmentPreviewOpened.value = false;
}

const isBodyNotEmpty = computed(() => {
    if (!props.post.body) return false;

    const parser = new DOMParser();
    const doc = parser.parseFromString(props.post.body, "text/html");

    const textContent = doc.body.textContent || '';
    return textContent.trim().length > 0;
});

</script>