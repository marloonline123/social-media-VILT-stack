import { useI18n } from "vue-i18n";

const useAttachmentValidation = (errors) => {
    const { t } = useI18n();
    const acceptedImageTypes = [
        "image/jpeg",
        "image/png",
        "image/jpg",
        "image/webp",
        "image/avif",
        "image/gif",
    ];
    const acceptedVideoTypes = ["video/mp4"];

    const validateAttachments = (attachments) => {
        errors.value = {
            body: "",
            attachments: [],
        };

        let isValid = true;

        attachments.forEach((attachment, index) => {
            let errorMessage = "";

            if (attachment.type.includes("image")) {
                if (!acceptedImageTypes.includes(attachment.type)) {
                    errorMessage = t("Image Type is not supported");
                } else if (attachment.size > 10000000) {
                    errorMessage = t("File size should not exceed 10MB");
                }
            } else if (attachment.type.includes("video")) {
                if (!acceptedVideoTypes.includes(attachment.type)) {
                    errorMessage = t("Video Type is not supported");
                } else if (attachment.size > 50000000) {
                    errorMessage = t("File size should not exceed 50MB");
                }
            } else {
                errorMessage = t("File Type is not supported");
            }

            if (errorMessage) {
                errors.value.attachments[index] = errorMessage;
                attachment.error = errorMessage;
                isValid = false;
            }
        });

        return isValid;
    };

    return { validateAttachments };
};

export default useAttachmentValidation;