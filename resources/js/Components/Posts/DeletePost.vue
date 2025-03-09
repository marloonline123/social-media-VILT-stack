<template>
    <div>
        <DropdownButton icon="fa-solid fa-trash" @click.stop="isDeleting = true">{{ $t('Delete') }}</DropdownButton>

        <!-- <Modal :show="isDeleting" @close="isDeleting = false">
            <Card class="p-4">
                <div class="py-3 px-2 flex items-center justify-between">
                    <Title>{{ $t('Delete Post') }}</Title>
                    <div @click="isDeleting = false">
                        <IconButton icon="fa-solid fa-times"></IconButton>
                    </div>
                </div>
                <hr class="mb-3">
                <form @submit.prevent="updatePost">
                    <div class="px-1 pb-5">
                        <p class="text-center text-xl">{{ $t('Are you sure you want to delete this post?') }}</p>
                    </div>

                    <hr class="mb-5">
                    <PrimaryButton :disabled="form.processing" class="text-lg bg-red-400 hover:bg-red-500"
                        icon="fa-regular fa-paper-plane">{{
                        $t('Delete') }}
                    </PrimaryButton>
                </form>
            </Card>
        </Modal> -->

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
import { ref, shallowRef } from 'vue';
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
const isDeleting = ref(false);
const form = useForm({
    body: post.body,
    _method: 'delete',
});

const deletePost = () => {
    form.post(route('posts.destroy', post.id), {
        onSuccess: () => {
            isDeleting.value = false;
            showToast(t('Post deleted successfully'));
        },
        preserveScroll: true,
    });
};
</script>
