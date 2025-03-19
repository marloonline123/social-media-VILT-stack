import '../css/app.css';
import './bootstrap';

import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createI18n } from 'vue-i18n';
import axios from 'axios';
import dayjs from 'dayjs';
import relativeTime from "dayjs/plugin/relativeTime";
import { useToast } from './Utl/useToast';
import store from './Store/Index';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const defaultLocale = localStorage.getItem("locale") || "en";

dayjs.extend(relativeTime);

const i18n = createI18n({
    legacy: false,
    locale: defaultLocale,
    messages: { [defaultLocale]: {} }, // Prevent warnings by providing an empty object initially
    missing: (locale, key) => {
        // console.warn(`[i18n] Missing translation: ${key} in ${locale}`);
        return key; // Return the key instead of undefined
    },
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),

    setup({ el, App, props, plugin }) {
        axios.get(`/localization?locale=${defaultLocale}`).then((response) => {
            i18n.global.setLocaleMessage(
                response.data.locale,
                response.data.translations
            );
        });

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .use(store)
            .mount(el);
            
    },
    progress: {
        color: '#4B5563',
    },
});

router.on("error", (event) => {
    if (event.status === 403) {
        const toast = useToast();
        toast.showToast('You are not authorized to perform this action.', 'error');
    }
});
