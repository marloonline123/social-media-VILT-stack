<template>
    <div>
        <Dropdown align="right" width="48">
            <template #trigger>
                <span class="inline-flex rounded-md">
                    <div class="relative">
                        <IconButton icon="fa-solid fa-globe" />
                    </div>
                </span>
            </template>

            <template #content>
                <button @click="changeLanguage('en')"
                    class="block w-full px-4 py-2 text-sm hover:text-slate-700 hover:bg-slate-100">
                    {{ $t('English') }}
                </button>
                <button @click="changeLanguage('ar')"
                    class="block w-full px-4 py-2 text-sm hover:text-slate-700 hover:bg-slate-100">
                    {{ $t('Arabic') }}
                </button>
            </template>
        </Dropdown>
    </div>
</template>

<script setup>
import Dropdown from '../Dropdown.vue';
import IconButton from '../IconButton.vue';
import { useI18n } from 'vue-i18n';
import { onMounted, watch } from 'vue';
import axios from 'axios';

const { locale, setLocaleMessage } = useI18n();

// Function to change language
const changeLanguage = async (lang) => {
    try {
        localStorage.setItem('locale', lang);
        locale.value = lang;

        // Save new locale in Laravel session
        await axios.post(`/switch-locale/${lang}`);

        // Fetch updated translations
        const response = await axios.get(`/localization?locale=${lang}`);
        setLocaleMessage(lang, response.data.translations);

        // Update lang and dir attributes dynamically
        document.documentElement.lang = lang;
        document.body.dir = lang === 'ar' ? 'rtl' : 'ltr';

    } catch (error) {
        console.error("Error switching language:", error);
    }
};

// Apply correct lang/dir when page loads
onMounted(() => {
    const lang = localStorage.getItem('locale') || 'en';
    document.documentElement.lang = lang;
    document.body.dir = lang === 'ar' ? 'rtl' : 'ltr';
    locale.value = lang;
});

// Watch for locale changes and update `lang` and `dir`
watch(locale, (newLang) => {
    document.documentElement.lang = newLang;
    document.body.dir = newLang === 'ar' ? 'rtl' : 'ltr';
});
</script>
