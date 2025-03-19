import { useI18n } from "vue-i18n";

const useTextValidation = (errors, form) => {
    
    
    const { t } = useI18n();
    const stripHtmlTags = (html) => {
        return html
            .replace(/<script[\s\S]*?>[\s\S]*?<\/script>/gi, "") // Remove <script> tags
            .replace(/<\/?[^>]+(>|$)/g, "") // Remove other HTML tags
            .trim(); // Trim whitespace
    };

    const decodeHTMLEntities = (text) => {
        const textarea = document.createElement("textarea");
        textarea.innerHTML = text;
        return textarea.value;
    };

    const validateData = () => {
        errors.value = {
            body: "",
            attachments: [],
        };
        if (!form.body && form.attachments.length === 0) {
            errors.value.body = t("Please add content or attachments");
            return false;
        }

        const decodedBody = decodeHTMLEntities(form.body);

        const cleanText = stripHtmlTags(form.body);

        if (form.attachments.length === 0 && cleanText.length < 5) {
            errors.value.body = t(
                "Content must contain at least 5 characters of text"
            );
            return false;
        }

        if (/<script\b[^>]*>([\s\S]*?)<\/script>/gi.test(decodedBody)) {
            errors.value.body = t("Script tags are not allowed");
            return false;
        }

        return true;
    };

    

    return { validateData };
}

export default useTextValidation;