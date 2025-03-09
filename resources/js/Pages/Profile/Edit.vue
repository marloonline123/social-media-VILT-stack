<template>

    <Head title="Profile" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ $t("Profile") }}
            </h2>
        </template>

        <div class="max-w-7xl mx-auto ">

            <div class="mx-auto relative max-w-5xl sm:px-6 lg:px-8 flex justify-center gap-3">
                
                <div class="w-[260px] hidden md:block h-full md:static flex-shrink-0">
                    <Card class="w-full">
                        <div class="mt-5">
                            <div class="list-none flex flex-col gap-1">
                                <button class="p-2 w-full flex gap-2 items-center capitalize leading-snug hover:bg-blue-50 dark:hover:bg-slate-600 rounded-md duration-200" :class="{'bg-blue-500 text-white hover:bg-blue-600 rounded-md': activeTap === 'info'}" @click="activeTap = 'info'" link="#" icon="fa-solid fa-user">{{ $t('Personal Infomation') }}</button>
                                <button class="p-2 w-full flex gap-2 items-center capitalize leading-snug hover:bg-blue-50 dark:hover:bg-slate-600 rounded-md duration-200" :class="{'bg-blue-500 text-white hover:bg-blue-600 rounded-md': activeTap === 'password'}" @click="activeTap = 'password'" link="#" icon="fa-solid fa-lock">{{ $t('Password & Security') }}</button>
                                <button class="p-2 w-full flex gap-2 items-center capitalize leading-snug hover:bg-blue-50 dark:hover:bg-slate-600 rounded-md duration-200" :class="{'bg-blue-500 text-white hover:bg-blue-600 rounded-md': activeTap === 'delete'}" @click="activeTap = 'delete'" link="#" icon="fa-solid fa-trash">{{ $t('Delete Account') }}</button>
                            </div>
                        </div>
                    </Card>
                </div>

                <Transition name="side">
                    <div v-if="tapsOpened" class="w-[260px] absolute md:hidden left-0 rtl:right-0 z-40 top-8 h-full md:static flex-shrink-0">
                        <Card class="w-full h-full">
                            <div class="mt-5">
                                <div class="list-none flex flex-col gap-1">
                                    <button class="p-2 w-full flex gap-2 items-center capitalize leading-snug hover:bg-blue-50 dark:hover:bg-slate-600 rounded-md duration-200" :class="{'bg-blue-500 text-white hover:bg-blue-600 rounded-md': activeTap === 'info'}" @click="activeTap = 'info'" link="#" icon="fa-solid fa-user">{{ $t('Personal Infomation') }}</button>
                                    <button class="p-2 w-full flex gap-2 items-center capitalize leading-snug hover:bg-blue-50 dark:hover:bg-slate-600 rounded-md duration-200" :class="{'bg-blue-500 text-white hover:bg-blue-600 rounded-md': activeTap === 'password'}" @click="activeTap = 'password'" link="#" icon="fa-solid fa-lock">{{ $t('Password & Security') }}</button>
                                    <button class="p-2 w-full flex gap-2 items-center capitalize leading-snug hover:bg-blue-50 dark:hover:bg-slate-600 rounded-md duration-200" :class="{'bg-blue-500 text-white hover:bg-blue-600 rounded-md': activeTap === 'delete'}" @click="activeTap = 'delete'" link="#" icon="fa-solid fa-trash">{{ $t('Delete Account') }}</button>
                                </div>
                            </div>
                        </Card>
                    </div>
                </Transition>

                <div class="flex-grow relative">
                    <Transition name="fade">
                        <div v-if="tapsOpened" @click="tapsOpened = false" class="absolute left-0 z-30 top-8 h-full w-full md:hidden bg-black/50 dark:bg-slate-900/50">
                        </div>
                    </Transition>
                    <div class="md:hidden">
                        <IconButton @click="tapsOpened = !tapsOpened" :icon="tapsOpened ? 'fa-solid fa-arrow-right' : 'fa-solid fa-arrow-left'" />
                    </div>
                    <div v-if="activeTap === 'info'" class="sm:rounded-lg">
                        <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status"
                            class="" />
                    </div>

                    <div v-if="activeTap === 'password'" class="sm:rounded-lg">
                        <UpdatePasswordForm class="" />
                    </div>

                    <div v-if="activeTap === 'delete'" class="sm:rounded-lg w-full">
                        <DeleteUserForm class="" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Card.vue';
import NavIitem from '@/Components/NavIitem.vue';
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import IconButton from '@/Components/IconButton.vue';

const { t } = useI18n();

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const activeTap = ref('info');
const tapsOpened = ref(false);

</script>
