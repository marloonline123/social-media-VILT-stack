<script setup>
import Card from '@/Components/Card.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);
const user = usePage().props.auth.user;

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy', user.username), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};

const { t } = useI18n();
</script>

<template>
    <Card class="">
        <header>
            <h2 class="text-lg font-medium">
                {{ $t("Delete Account") }}
            </h2>

            <p class="my-2 mb-4 text-sm">
                {{ $t("Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.") }}
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">{{ $t("Delete Account") }}</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium">
                    {{ $t("Are you sure you want to delete your account?") }}
                </h2>

                <p class="mt-1 text-sm">
                    {{ $t("Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.") }}
                </p>

                <div class="mt-6">
                    <InputLabel for="password" :value="$t('Password')" class="sr-only" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        {{ $t("Cancel") }}
                    </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteUser">
                        {{ $t("Delete Account") }}
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </Card>
</template>
