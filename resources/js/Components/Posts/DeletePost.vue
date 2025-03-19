<template>
    <div>
        <DropdownButton icon="fa-solid fa-trash" @click.stop="isDeleting = true">{{ $t('Delete') }}</DropdownButton>

        <Modal :show="isDeleting" @close="isDeleting = false" :title="$t('Delete Post')">
            <div class="my-4 text-center">{{ $t('Are you sure you want to delete this post? This action cannot be undone.') }}</div>
            <template #footer>
                <PrimaryButton @click="deletePost" :disabled="form.processing" class="text-lg bg-red-400 hover:bg-red-500 active:bg-red-600 focus:bg-red-500 focus:ring-red-500"
                    icon="fa-regular fa-paper-plane">{{
                        $t('Delete') }}
                </PrimaryButton>
            </template>
        </Modal>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DropdownButton from '../DropdownButton.vue';
import Modal from '../Modal/Modal.vue';
import PrimaryButton from '../PrimaryButton.vue';
import { useToast } from '@/Utl/useToast';
import { useI18n } from 'vue-i18n';

const { post } = defineProps({
    post: {
        type: Object,
        required: true,
    },
});

const { showToast } = useToast();
const { t } = useI18n();
const emit = defineEmits(['close-dropdown']);
const isDeleting = ref(false);
const form = useForm({
    body: post.body,
    _method: 'delete',
});

const deletePost = () => {
    form.post(route('posts.destroy', post.id), {
        onSuccess: () => {
            isDeleting.value = false;
            emit('close-dropdown');
            showToast(t('Post deleted successfully'));
        },
        preserveScroll: true,
    });
};
</script>
