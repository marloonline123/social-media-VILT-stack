<template>
    <div>
        <div id="post-body" class="mb-3">
            <p class="" v-html="post.body"></p>
        </div>
        <div v-show="post.attachments.length > 0" class="w-full grid grid-cols-1 gap-1"
            :class="{ 'grid-cols-2': post.attachments.length > 1 }">
            <div v-for="(attachment, index) in post.attachments" :key="index">
                <div v-if="attachment.mime.includes('image')">
                    <img class="w-full object-cover" :class="{ 'h-[200px]': post.attachments.length > 1 }"
                        :src="attachment.preview" alt="" />
                </div>
                <div v-if="attachment.mime.includes('video')">
                    <video class="w-full object-cover" :class="{ 'h-[200px]': post.attachments.length > 1 }"
                        :src="attachment.preview" alt="" controls></video>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

defineProps({
    post: {
        type: Object,
        required: true
    }
})

</script>