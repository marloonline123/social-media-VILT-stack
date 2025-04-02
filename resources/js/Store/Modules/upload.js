import axios from "axios";
import { router } from "@inertiajs/vue3";

export default {
    namespaced: true,
    state: {
        uploads: [],
    },
    mutations: {
        ADD_UPLOAD(state, upload) {
            console.log("[MUTATION] ADD_UPLOAD:", upload);
            state.uploads.push(upload);
        },
        UPDATE_PROGRESS(state, { id, progress, name, status }) {
            const upload = state.uploads.find((u) => u.id === id);
            if (upload) {
                console.log("status", upload.status);

                console.log(
                    `[MUTATION] UPDATE_PROGRESS: ID=${id}, Progress=${progress}%`
                );
                upload.name = name;
                upload.status = status;
                upload.progress = progress;
            } else {
                console.warn(
                    `[WARNING] UPDATE_PROGRESS: Upload ID=${id} not found`
                );
            }
        },
        REMOVE_UPLOAD(state, id) {
            console.log("[MUTATION] REMOVE_UPLOAD: ID=", id);
            const initialLength = state.uploads.length;
            state.uploads = state.uploads.filter((u) => u.id !== id);
            console.log(
                `[MUTATION] REMOVE_UPLOAD: Before=${initialLength}, After=${state.uploads.length}`
            );
        },
    },
    actions: {
        async uploadPost({ commit }, { body, attachments, postable_id, postable_type }) {
            if (!body && attachments.length === 0) return;

            const uploadId = Date.now().toString();
            console.log(
                "[ACTION] uploadPost: Starting upload with ID=",
                uploadId
            );
            commit("ADD_UPLOAD", {
                id: uploadId,
                name: "Uploading...",
                progress: 0,
                status: "uploading",
            });

            try {
                const formData = new FormData();
                formData.append("body", body);
                if (postable_id && postable_type) {
                    formData.append("postable_id", postable_id);
                    formData.append("postable_type", postable_type);
                }
                attachments.forEach((file, index) => {
                    formData.append(`attachments[${index}]`, file);
                });

                await axios
                    .post(route("posts.store"), formData, {
                        headers: { "Content-Type": "multipart/form-data" },
                        onUploadProgress: (event) => {
                            if (event.lengthComputable) {
                                const progress = Math.round(
                                    (event.loaded * 100) / event.total
                                );
                                commit("UPDATE_PROGRESS", {
                                    id: uploadId,
                                    progress,
                                    name:
                                        progress < 100
                                            ? "Uploading..."
                                            : "Processing...",
                                    status:
                                        progress < 100
                                            ? "uploading"
                                            : "processing",
                                });
                            }
                        },
                    })
                    .then((response) => {
                        console.log("the updated Post", response.data.post);
                        this.commit("Posts/updatePost", response.data.post);
                    });

                console.log(
                    "[ACTION] uploadPost: Upload completed, attempting to remove ID=",
                    uploadId
                );
                commit("REMOVE_UPLOAD", uploadId);

                this.commit("Posts/updatePost", );
                // router.reload({ only: ["posts"] });
            } catch (error) {
                console.error(
                    "[ERROR] uploadPost: Upload failed for ID=",
                    uploadId,
                    error
                );
                commit("UPDATE_PROGRESS", {
                    id: uploadId,
                    progress: 100,
                    status: "error",
                    name: "Failed to upload",
                });
            }
        },
        async updatePost(
            { commit },
            { body, attachments, removedAttachments, postId }
        ) {
            if (!body && attachments.length === 0) return;

            const uploadId = Date.now().toString();
            console.log(
                "[ACTION] uploadPost: Starting upload with ID=",
                uploadId
            );
            commit("ADD_UPLOAD", {
                id: uploadId,
                name: "Uploading...",
                progress: 0,
                status: "uploading",
            });

            try {
                const formData = new FormData();
                formData.append("body", body);
                formData.append("removedAttachments", JSON.stringify(removedAttachments));
                formData.append("_method", "PUT");
                attachments.forEach((file, index) => {
                    formData.append(`attachments[${index}]`, file);
                });

                await axios.post(route("posts.update", postId), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                    onUploadProgress: (event) => {
                        if (event.lengthComputable) {
                            const progress = Math.round(
                                (event.loaded * 100) / event.total
                            );
                            commit("UPDATE_PROGRESS", {
                                id: uploadId,
                                progress,
                                name:
                                    progress < 100
                                        ? "Uploading..."
                                        : "Processing...",
                                status:
                                    progress < 100 ? "uploading" : "processing",
                            });
                        }
                    },
                }).then((response) => {
                    console.log("the updated Post", response.data.post);
                    this.commit("Posts/updatePost", response.data.post);
                });

                console.log(
                    "[ACTION] uploadPost: Upload completed, attempting to remove ID=",
                    uploadId
                );
                commit("REMOVE_UPLOAD", uploadId);

                router.reload({ only: ["posts"] });
            } catch (error) {
                console.error(
                    "[ERROR] uploadPost: Upload failed for ID=",
                    uploadId,
                    error
                );
                commit("UPDATE_PROGRESS", {
                    id: uploadId,
                    progress: 100,
                    status: "error",
                    name: "Failed to upload",
                });
            }
        },
        async deleteUpload({ commit }, id) {
            console.log("[ACTION] deleteUpload: ID=", id);
            commit("REMOVE_UPLOAD", id);
        },
    },
};
