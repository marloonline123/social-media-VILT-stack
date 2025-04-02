<template>
  <Head title="Home" />
  <AppLayout>
    <div class="h-full">
      <div class="h-full flex gap-5 relative w-full">
        <div class="w-1/4 hidden lg:block">
          <LeftColumn :pages="pages" />
        </div>
        <div class="h-full w-full md:w-2/3 lg:w-2/4">
          <MiddleColumn />
        </div>
        <div class="hidden md:block md:w-1/3 lg:w-1/4">
          <RightColumn :groups="groups" :followers="followers" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import LeftColumn from "@/Components/MainSections/LeftColumn.vue";
import MiddleColumn from "@/Components/MainSections/MiddleColumn.vue";
import RightColumn from "@/Components/MainSections/RightColumn.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  groups: {
    type: Object,
    required: true,
  },
  followers: {
    type: Object,
    required: true,
  },
  pages: {
    type: Object,
    required: true,
  },
});
const groups = computed(() => props.groups.data);
const followers = computed(() => props.followers.data);
const pages = computed(() => props.pages.data);
</script>
