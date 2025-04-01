<template>
  <Card class="mt-3">
    <section class="py-6">
      <!-- Header Section -->
      <div class="text-center">
        <h3 class="text-3xl font-extrabold text-gray-800">📸 Beautiful Gallery</h3>
        <p class="text-gray-500 mt-2">Explore this group’s stunning media collection!</p>
      </div>

      <!-- Gallery Grid -->
      <div class="mt-8">
        <div
          v-if="attachments.length > 0"
          class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-4"
        >
          <GalleryCard
            v-for="attachment in attachments"
            :attachment="attachment"
            :key="attachment.id"
            @click="openPreview(attachments.indexOf(attachment))"
          />
        </div>
        <p v-else class="text-center text-gray-500 mt-4">
          This Group does not have any media.
        </p>
      </div>
    </section>

    <FullAttachmentPreview
      v-if="isPreviewOpen"
      :closeAttachmentPreview="closePreview"
      :activeAttachmentIndex="activePreview"
      :attachments="attachments"
    />
  </Card>
</template>

<script setup>
import Card from "@/Components/Card.vue";
import FullAttachmentPreview from "@/Components/Posts/Attachments/FullAttachmentPreview.vue";
import GalleryCard from "@/Pages/Profile/Partials/ProfileTaps/Partials/GalleryCard.vue";
import { ref } from "vue";

defineProps({
  attachments: { type: Array, required: true },
});

const isPreviewOpen = ref(false);
const activePreview = ref(0);
const openPreview = (index = 0) => {
  isPreviewOpen.value = true;
  activePreview.value = index;
};

const closePreview = () => {
  isPreviewOpen.value = false;
};
</script>
