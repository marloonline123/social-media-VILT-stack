<template>
    <div>
        <CreatePostOverlay :openModal="openModal"/>

        <!-- Edit Post Modal -->
        <Modal :show="modalOpened" @close="closeModal" :title="$t('Create Post')">
            <EditorComponent  v-if="modalOpened" @update:body="updateBody" @update:attachments="updateAttachments" :modalOpened="modalOpened" :body="form.body" />

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
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '../PrimaryButton.vue';
import { useToast } from '@/Utl/useToast';
import { useI18n } from 'vue-i18n';
import Modal from '../Modal/Modal.vue';
import CreatePostOverlay from './CreatePostOverlay.vue';
import EditorComponent from './EditorComponent.vue';



const { showToast } = useToast();
const { t } = useI18n();
const modalOpened = ref(false);

const form = useForm({
    body: '',
    attachments: [],
});

const updateBody = (body) => {
    form.body = body;
}

const updateAttachments = (attachments) => {
    form.attachments = attachments;
}

const createPost = () => {
    form.post(route('posts.store'), {
        onSuccess: () => {
            form.reset();
            closeModal();
            showToast(t('Post Created successfully'));
        },
        preserveScroll: true,
    });
};

const openModal = () => {
    modalOpened.value = true;
}

const closeModal = () => {
    modalOpened.value = false;
};


</script>
