<template>
  <div
    class="relative group cursor-pointer rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300"
  >
    <!-- Image Preview -->
    <div v-if="attachment.mime.includes('image')" class="relative bg-slate-400">
      <Image
        class="w-full h-48 object-contain group-hover:scale-105 transition-transform duration-300"
        :src="attachment.preview"
        alt="Gallery Image"
      />
    </div>

    <!-- Video Preview -->
    <div v-if="attachment.mime.includes('video')" class="relative">
      <Video
        class="w-full h-48 group-hover:scale-105 transition-transform duration-300"
        :src="attachment.preview"
        controls
      ></Video>
    </div>

    <!-- Overlay for Hover Effect -->
    <div
      class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300"
    >
      <span class="text-white font-semibold text-sm">View Media</span>
    </div>
  </div>
</template>

<script setup>
import Image from "@/Components/Image.vue";
import Video from "@/Components/Video.vue";

defineProps({
  attachment: { type: Object, required: true },
});
</script>
