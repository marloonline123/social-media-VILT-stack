<template>
    <div>
        <Card class="py-4">
            <div class="flex items-center gap-2" @click="openModal = true">
                <TextInput v-model="emptyModel" class="flex-grow" :placeholder="$t('What\'s on your mind')" />
                <IconButton class="text-lg" icon="fa-regular fa-paper-plane"></IconButton>
            </div>
        </Card>

        <!-- Edit Post Modal -->
        <Modal :show="openModal" @close="closeEditor" :title="$t('Create Post')">
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
                            <Editor v-if="openModal" ref="editorContainer"
                                style="height: 150px; overflow-y: hidden; background-color: transparent"
                                v-model="form.body" :defaultConfig="editorConfig" mode="default"
                                @onCreated="handleCreated" />
                        </div>

                        <div class="pt-8 relative">
                            <div class="mt-4 px-3 grid grid-cols-1 gap-2"
                                :class="{ 'grid-cols-2': attachments.length > 1 }" v-if="attachments.length > 0">
                                <div v-for="(attachment, index) in attachments" :key="index" class="">
                                    <div v-if="attachment.type.includes('image')"
                                        class="w-full border border-slate-200 relative dark:border-slate-600 rounded-md flex items-center justify-center">
                                        <button @click="deleteAttachment(index)"
                                            class="absolute top-2 right-2 z-20 bg-white shadow-md rounded-full w-[25px] h-[25px] grid place-items-center cursor-pointer hover:bg-slate-100 duration-150">
                                            <i class="fa-solid fa-times cursor-pointer"></i>
                                        </button>
                                        <img :src="attachment.preview" alt="Attachment Preview"
                                            class="h-[400px] w-full object-cover rounded-md"
                                            :class="{ 'h-[180px]': attachments.length > 1 }">
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

                            </div>

                            <div class="absolute top-2 right-5">
                                <div>
                                    <input @change="handleFileUpload" type="file" id="file" name="file" class="hidden"
                                        multiple />
                                    <label for="file" class="cursor-pointer">
                                        <span
                                            class="px-2 py-1 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-md duration-150">
                                            <i class="fa-solid fa-photo-film"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <template #footer>
                <div class="flex gap-2">
                    <PrimaryButton @click="createPost" :disabled="form.processing" class="text-lg"
                        icon="fa-regular fa-paper-plane">
                        {{ $t('Save') }}
                    </PrimaryButton>
                </div>
            </template>
        </Modal>
    </div>
</template>

<script setup>
import '@wangeditor/editor/dist/css/style.css';
import { ref, shallowRef, nextTick, onBeforeUnmount } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '../PrimaryButton.vue';
import { useToast } from '@/Utl/useToast';
import { useI18n } from 'vue-i18n';
import { Editor } from '@wangeditor/editor-for-vue';
import Modal from '../Modal/Modal.vue';
import Card from '../Card.vue';
import TextInput from '../TextInput.vue';
import IconButton from '../IconButton.vue';

const isDragging = ref(false);
const dragCounter = ref(0);
const editorConfig = { placeholder: 'Type Something here...', innerHeight: 300 };
const editorRef = shallowRef(null);
const editorContainer = ref(null);

const { showToast } = useToast();
const { t } = useI18n();
const openModal = ref(false);
const emptyModel = ref('')

const form = useForm({
    body: '',
    attachments: [],
});

const attachments = ref([]);

const handleFileUpload = (event) => {
    if (!event.target.files.length) return; // Prevent adding empty files
    const files = Array.from(event.target.files);
    files.forEach((file) => {
        file.preview = URL.createObjectURL(file);
        attachments.value.push(file);
    });
    form.attachments = attachments.value;
};

const deleteAttachment = (index) => {
    attachments.value.splice(index, 1);
};

const openEditor = async () => {
    openModal.value = true;
    await nextTick();
};

const closeEditor = () => {
    openModal.value = false;
    destroyEditor();
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

const createPost = () => {
    form.post(route('posts.store'), {
        onSuccess: () => {
            closeEditor();
            showToast(t('Post Created successfully'));
        },
        preserveScroll: true,
    });
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
        attachments.value.push(file);
    });
    form.attachments = attachments.value;
};


onBeforeUnmount(destroyEditor);
</script>
