<script setup>
import { useUploadPost } from "@/Composables/useUploadPost";
import Card from "../Card.vue";
import { useStore } from "vuex";
import { computed } from "vue";
import IconButton from "../IconButton.vue";

const store = useStore();
const uploads = computed(() => store.state.Upload.uploads);
</script>

<template>
    <div v-if="uploads.length > 0">
        <Card class="flex flex-col gap-2">
            <h4 class="p-2 underline">Please Don't Close This Page Until Upload Is Fully Finished!</h4>
            <div v-for="upload in uploads" :key="upload.id" class="w-full p-2">
                <div v-if="upload.status === 'error'" class="flex justify-between items-center gap-2">
                    <p class="text-red-500">
                        {{ upload.name }}
                    </p>
                    <IconButton icon="fa-solid fa-xmark" @click="store.dispatch('Upload/deleteUpload', upload.id)" />
                </div>
                <div v-else>
                    <p v-if="upload.progress < 100">{{ upload.name }} - {{ upload.progress }}%</p>
                    <p v-else>{{ upload.name }}</p>
                </div>
                <div class="bg-slate-300 h-2 rounded w-full mt-2">
                    <span
                        class="bg-gradient-to-r from-sky-500 to-blue-500 transition-all duration-2s ease-in block h-2 rounded"
                        :style="{ width: upload.progress + '%' }" :class="{ 'from-rose-500 to-red-300': upload.status === 'error' }">
                    </span>
                </div>
                
            </div>
        </Card>
    </div>
</template>
