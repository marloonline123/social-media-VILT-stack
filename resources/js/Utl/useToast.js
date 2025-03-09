import { inject } from "vue";

export const useToast = () => {
    const showToast = inject("toast");

    if (!showToast) {
        console.warn("useToast() called but no toast provider found!");
    }

    return { showToast };
};

