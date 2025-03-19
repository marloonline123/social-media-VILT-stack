<template>
    <div>
        <!-- Edit Button -->
        <DropdownButton icon="fa-solid fa-pencil" @click.stop="openModal">
            {{ $t('Edit') }}
        </DropdownButton>

        <Modal :show="modalOpened" @close="closeModal" :title="$t('Create Post')">
            <ValidationError :for="errors.body" class="mx-1" />
            <EditorComponent v-if="modalOpened" @update:body="updateBody" @update:attachments="updateAttachments"
                :modalOpened="modalOpened" @removeAttachment="handleRemoveAttachment" :body="form.body"
                :attachments="attachments" />

            <template #footer>
                <div class="flex gap-2">
                    <PrimaryButton @click="updatePost" :disabled="form.processing" class="text-lg"
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
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '../PrimaryButton.vue';
import { useToast } from '@/Utl/useToast';
import { useI18n } from 'vue-i18n';
import Modal from '../Modal/Modal.vue';
import DropdownButton from '../DropdownButton.vue';
import EditorComponent from './EditorComponent.vue';
import ValidationError from '../ValidationError.vue';
import useTextValidation from '@/Composables/useTextValidation';
import useAttachmentValidation from '@/Composables/useAttachmentValidation';
import { useStore } from 'vuex';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['close-dropdown']);

const attachments = ref(props.post.attachments);
const store = useStore();

const form = useForm({
    body: props.post.body ?? '',
    attachments: [],
    removedAttachments: [],
    _method: 'put',
});

const { showToast } = useToast();
const { t } = useI18n();
const modalOpened = ref(false);
const errors = ref({
    body: "",
    attachments: [],
});

const { validateData } = useTextValidation(errors, form);
const { validateAttachments } = useAttachmentValidation(errors);

const updateBody = (body) => {
    form.body = body;
}

const updateAttachments = (attachments) => {
    form.attachments = attachments;
}

const handleRemoveAttachment = (removedAttachment) => {
    if (removedAttachment.id) {
        attachments.value = attachments.value.filter((attch) => attch !== removedAttachment);
        form.removedAttachments.push(removedAttachment);
    }
}

const openModal = () => {
    modalOpened.value = true;
}

const closeModal = () => {
    form.reset();
    emit('close-dropdown');
    modalOpened.value = false;
};

const updatePost = () => {
    if (!validateData()) return false;
    if (!validateAttachments(form.attachments)) return false;
    
    store.dispatch("Upload/updatePost", { body: form.body, attachments: form.attachments, removedAttachments: form.removedAttachments, postId: props.post.id });
    closeModal();
};
</script>
