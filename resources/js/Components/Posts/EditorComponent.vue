<template>
    <div>
        <Transition name="fade">
            <div v-show="isDragging" @dragleave.prevent="handleDragLeave" @dragover.prevent="handleDragOver"
                @dragenter.prevent="handleDragEnter" @drop="handleDrop"
                class="absolute z-30 top-0 right-0 left-0 bottom-0 w-full h-full bg-slate-900/30 justify-center items-center flex text-4xl text-blue-600">
                <div class="flex flex-col items-center gap-3">
                    <span>{{ $t('Drop to upload') }}</span>
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>
            </div>
        </Transition>

        <div class="relative" @dragover.prevent="handleDragOver" @dragenter.prevent="handleDragEnter">
            <form @submit.prevent="updatePost">
                <div>
                    <div>
                        <Editor v-if="modalOpened" ref="editorContainer" :modelValue="body"
                            @update:modelValue="$emit('update:body', $event)"
                            style="height: 150px; overflow-y: hidden; background-color: transparent"
                            :defaultConfig="editorConfig" mode="default" @onCreated="handleCreated" />
                    </div>

                    <AttachmentsPreview :attachmentsErrors="attatchmentsErrors" @handleAttachments="handleFileUpload" @removeAttachment="handleRemoveAttachment"
                        :attachments="attachments" :uploadedAttachments="uploadedAttachments" />
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Editor } from '@wangeditor/editor-for-vue';
import '@wangeditor/editor/dist/css/style.css';
import { onBeforeUnmount, ref, shallowRef } from 'vue';
import AttachmentsPreview from './Attachments/AttachmentsPreview.vue';
import useAttachmentValidation from '@/Composables/useAttachmentValidation';


const emit = defineEmits(['update:body', 'update:attachments', 'removeAttachment']);

const props = defineProps({
    modalOpened: {
        type: Boolean,
        default: false
    },
    body: {
        type: String,
        default: ''
    },
    attachments: {
        type: Array,
        default: []
    }
})

const uploadedAttachments = ref([]);
const isDragging = ref(false);
const editorConfig = { placeholder: 'Type Something here...', innerHeight: 300 };
const editorRef = shallowRef(null);
const editorContainer = ref(null);
const attatchmentsErrors = ref([]);
const { validateAttachments } = useAttachmentValidation(attatchmentsErrors);

console.log('ready Attachments', props.attachments);


const handleFileUpload = (event) => {
    uploadedAttachments.value.push(...event);
    validateAttachments(uploadedAttachments.value);
    console.log('attachments', uploadedAttachments.value);
    
    emit('update:attachments', uploadedAttachments.value);
};

const handleRemoveAttachment = (removedAttachment) => {
    if (!removedAttachment.id) {
        uploadedAttachments.value = uploadedAttachments.value.filter((attch) => attch !== removedAttachment);
        console.log('removed uploadedAttachments', removedAttachment);
    } else {
        console.log('removed ready Attachments', removedAttachment);
        emit('removeAttachment', removedAttachment);
    }
    
};

const handleCreated = (editor) => {
    if (!editor) return;
    editorRef.value = editor;
};

const destroyEditor = () => {
    if (editorRef.value) {
        editorRef.value.destroy();
        editorRef.value = null;
    }
};

const handleDragOver = (event) => {
    event.preventDefault();
    event.dataTransfer.dropEffect = 'copy';
};

const handleDragEnter = (event) => {
    event.preventDefault();
    isDragging.value = true;
};

const handleDragLeave = (event) => {
    event.preventDefault();

    isDragging.value = false;
};

const handleDrop = (event) => {
    event.preventDefault();
    event.stopPropagation();
    isDragging.value = false;

    if (!event.dataTransfer.files.length) return;
    processFiles(event.dataTransfer.files);
};

const processFiles = (files) => {
    const newFiles = Array.from(files);
    newFiles.forEach((file) => {
        file.preview = URL.createObjectURL(file);
        uploadedAttachments.value.push(file);
    });
    
    emit('update:attachments', uploadedAttachments.value);
};


onBeforeUnmount(() => {
    uploadedAttachments.value = [];
    destroyEditor();
});
</script>