<template>
    <Card class="max-w-full">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ $t("Profile Information") }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ $t("Update your account's profile information and email address.") }}
            </p>
        </header>

        <form @submit.prevent="submit"
            class="mt-6 space-y-6">
            <div class="flex items-center gap-4">
                <Title class="font-normal text-lg">{{ $t("Avatar") }}</Title>

                <input @change="handleImageChange" type="file"  id="avatar" class="hidden" accept="image/*" />
                <label
                    class="h-[100px] w-[100px] group flex items-center justify-center cursor-pointer bg-blue-500 rounded-full border-4 border-slate-100 dark:border-slate-700 relative overflow-hidden"
                    for="avatar">
                    <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                        <span
                            class="hidden group-hover:block z-50 duration-150 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white">
                            <i class="fa-solid fa-pen"></i>
                        </span>
                    </Transition>
                    <img class="w-full h-full object-cover group-hover:opacity-80 duration-150"
                        :src=" image.preview ?? '/storage/' + user.avatar" alt="">
                </label>

                <InputError class="mt-2" :message="form.errors.avatar" />
            </div>

            <div class="flex items-center gap-4">
                <Title class="font-normal text-lg">{{ $t("Cover Image") }}</Title>

                <input @change="handleCoverImageChange" type="file"  id="cover_image" class="hidden" accept="image/*" />
                <label
                    class="h-[100px] w-full group flex items-center justify-center cursor-pointer bg-blue-500 rounded-md border-4 border-slate-300 dark:border-slate-600 relative overflow-hidden"
                    for="cover_image">
                    <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                        <span
                            class="hidden group-hover:block z-50 duration-150 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white">
                            <i class="fa-solid fa-pen"></i>
                        </span>
                    </Transition>
                    <img class="w-full h-full object-cover group-hover:opacity-80 duration-150"
                        :src="image.preview_cover_image ?? '/storage/' + user.cover_image" alt="" onerror="https://addcovers.com/covers/anubgendls898ni.jpg">
                </label>

                <InputError class="mt-2" :message="form.errors.cover_image" />
            </div>

            <div>
                <InputLabel for="name" :value="$t('Name')" />

                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                    autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="username" :value="$t('Username')" />

                <TextInput id="username" type="text" class="mt-1 block w-full" v-model="form.username" required
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div>
                <InputLabel for="email" :value="$t('Email')" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
                    {{ $t("Your email address is unverified.") }}
                    <Link :href="route('verification.send')" method="post" as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800">
                    {{ $t("Click here to re-send the verification email.") }}
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                    {{ $t("A new verification link has been sent to your email address.") }}
                </div>
            </div>

            <div>
                <InputLabel for="bio" :value="$t('Bio')" />

                <TextArea id="bio" type="text" class="mt-1 block w-full" v-model="form.bio" autocomplete="bio"></TextArea>

                <InputError class="mt-2" :message="form.errors.bio" />
            </div>

            <div class="mt-4">
                <Title>{{ $t("Gender") }}</Title>

                <div class="flex gap-2 mt-2">
                    <!-- Male -->
                    <div>
                        <input v-model="form.gender" class="peer hidden" type="radio" id="gender-male" name="gender"
                            value="male" />
                        <label for="gender-male"
                            class="flex items-center gap-2 cursor-pointer border-2 peer-checked:ring-2 peer-checked:ring-blue-500 rounded-md py-2 px-4 bg-slate-100 dark:bg-slate-700 transition">
                            <span>{{ $t("Male") }}</span>
                        </label>
                    </div>

                    <!-- Female -->
                    <div>
                        <input v-model="form.gender" class="peer hidden" type="radio" id="gender-female" name="gender"
                            value="female" />
                        <label for="gender-female"
                            class="flex items-center gap-2 cursor-pointer border-2 peer-checked:ring-2 peer-checked:ring-blue-500 rounded-md py-2 px-4 bg-slate-100 dark:bg-slate-700 transition">
                            <span>{{ $t("Female") }}</span>
                        </label>
                    </div>
                </div>

                <InputError class="mt-2" :message="form.errors.gender" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">{{ $t("Save") }}</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $t("Saved.") }}
                    </p>
                </Transition>
            </div>
        </form>
    </Card>
</template>

<script setup>
import Card from '@/Components/Card.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import Title from '@/Components/Title.vue';
import { useToast } from '@/Utl/useToast';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, Transition } from 'vue';
import { useI18n } from 'vue-i18n';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const { showToast } = useToast();
const { t } = useI18n();

const form = useForm({
    name: user.name,
    email: user.email,
    username: user.username,
    bio: user.bio,
    gender: user.gender,
    avatar: null,
    cover_image: null,
    _method: 'patch',
});

const image = ref({
    preview: null,
    preview_cover_image: null,
});

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (!file) return;
    image.value.preview = URL.createObjectURL(file);

    form.avatar = file;
};

const handleCoverImageChange = (event) => {
    const file = event.target.files[0];
    if (!file) return;
    image.value.preview_cover_image = URL.createObjectURL(file);

    form.cover_image = file;
};

const submit = () => {
    form.post(route('profile.update', user.username), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            showToast(t('Profile updated successfully'), 'success');
        }
    });
};


</script>
