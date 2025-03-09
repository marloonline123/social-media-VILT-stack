<template>
    <div>
        <!-- Edit Button -->
        <DropdownButton icon="fa-solid fa-pencil" @click.stop="openModal">
            {{ $t('Edit') }}
        </DropdownButton>

        <Modal :show="modalOpened" @close="closeModal" :title="$t('Create Post')">
            <EditorComponent @update:body="updateBody" @update:attachments="updateAttachments"
                :modalOpened="modalOpened" :body="form.body" :attachments="post.attachments" />

            <template #footer>
                <div class="flex gap-2">
                    <PrimaryButton @click="updatePost" :disabled="form.processing" class="text-lg"
                        icon="fa-regular fa-paper-plane">
                        {{ $t('Save') }}
                    </PrimaryButton>
                </div>
            </template>
        </Modal>

        <!-- Edit Post Modal -->
        <!-- <Modal :show="modalOpened" @close="closeEditor" :title="$t('Edit Post')">
            <form @submit.prevent="updatePost">
                <div>
                    <div>
                        <Editor v-if="modalOpened" ref="editorContainer"
                            style="height: 200px; overflow-y: hidden; background-color: transparent" v-model="form.body"
                            :defaultConfig="editorConfig" mode="default" @onCreated="handleCreated" />
                    </div>
                </div>
            </form>

            <template #footer>
                <PrimaryButton @click="updatePost" :disabled="form.processing" class="text-lg" icon="fa-regular fa-paper-plane">
                    {{ $t('Save') }}
                </PrimaryButton>
            </template>
        </Modal> -->
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
import DropdownButton from '../DropdownButton.vue';
import EditorComponent from './EditorComponent.vue';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    body: props.post.body ?? '',
    attachments: [],
    _method: 'put',
});

const { showToast } = useToast();
const { t } = useI18n();
const modalOpened = ref(false);

const updateBody = (body) => {
    console.log("Body updated:", body);
    form.body = body;
}

const updateAttachments = (attachments) => {
    console.log("Attachments updated:", attachments);
    form.attachments = attachments;
}

const openModal = () => {
    modalOpened.value = true;
}

const closeModal = () => {
    modalOpened.value = false;
};

const updatePost = () => {
    form.post(route('posts.update', props.post.id), {
        onSuccess: () => {
            closeModal();
            showToast(t('Post updated successfully'));
        },
        preserveScroll: true,
    });
};
</script>
