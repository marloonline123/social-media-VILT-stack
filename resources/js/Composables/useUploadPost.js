import { ref } from "vue";
import axios from "axios";
import { useToast } from "@/Utl/useToast";
import { useI18n } from "vue-i18n";

export function useUploadPost() {
    const { showToast } = useToast();
    const { t } = useI18n();

    const uploading = ref(false);
    const uploadQueue = ref([]); // Tracks ongoing uploads

    // Function to upload a post
    const uploadPost = async (body, attachments) => {
        if (!body && attachments.length === 0) {
            showToast(t("Please add content or attachments"), {
                type: "error",
            });
            return;
        }

        // Create a unique ID for this upload
        const uploadId = Date.now();
        uploadQueue.value.push({
            id: uploadId,
            progress: 0,
            name: "Uploading...",
        });

        uploading.value = true;

        try {
            const formData = new FormData();
            formData.append("body", body);
            attachments.forEach((file, index) => {
                formData.append(`attachments[${index}]`, file);
            });

            const response = await axios.post(route("posts.store"), formData, {
                headers: { "Content-Type": "multipart/form-data" },
                onUploadProgress: (progressEvent) => {
                    if (progressEvent.lengthComputable) {
                        const totalProgress = Math.round(
                            (progressEvent.loaded * 100) / progressEvent.total
                        );
                        const uploadItem = uploadQueue.value.find(
                            (item) => item.id === uploadId
                        );
                        if (uploadItem) uploadItem.progress = totalProgress;
                    }
                },
            });

            // Remove from queue after upload completes
            uploadQueue.value = uploadQueue.value.filter(
                (item) => item.id !== uploadId
            );
            showToast(t("Post Created successfully"));
        } catch (error) {
            console.error("Upload failed:", error);
            showToast(t("Post creation failed"), { type: "error" });
        } finally {
            uploading.value = uploadQueue.value.length > 0; // Keep true if more uploads exist
        }
    };

    return { uploading, uploadQueue, uploadPost };
}
