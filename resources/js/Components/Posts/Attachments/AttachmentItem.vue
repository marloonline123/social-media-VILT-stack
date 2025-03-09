<template>
    <div>
        <div v-if="attachment.type.includes('image')"
            class="w-full border border-slate-200 relative dark:border-slate-600 rounded-md flex items-center justify-center">
            <button @click="deleteAttachment(index)"
                class="absolute top-2 right-2 z-20 bg-white shadow-md rounded-full w-[25px] h-[25px] grid place-items-center cursor-pointer hover:bg-slate-100 duration-150">
                <i class="fa-solid fa-times cursor-pointer"></i>
            </button>
            <img :src="attachment.preview" alt="Attachment Preview" class="w-full object-cover rounded-md"
                :class="{ 'h-[180px]': attachments.length > 1, 'h-[400px]': attachments.length == 1 }" >
        </div>

        <div v-if="attachment.type.includes('video')"
            class="w-full border relative group border-slate-200 dark:border-slate-600 rounded-md flex items-center justify-center">
            <button @click="deleteAttachment(index)"
                class="absolute top-2 right-2 z-20 bg-white shadow-md rounded-full w-[25px] h-[25px] grid place-items-center cursor-pointer hover:bg-slate-100 duration-150">
                <i class="fa-solid fa-times cursor-pointer"></i>
            </button>
            <video :src="attachment.preview" controls alt="Attachment Preview"
                class="h-full w-full object-cover rounded-md"></video>
        </div>
    </div>
</template>

<script setup>
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
    },
    deleteAttachment: {
        type: Function,
        required: true
    }
})

console.log('prop attachment', props.attachments);


</script>