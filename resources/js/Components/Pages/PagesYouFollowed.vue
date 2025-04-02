<template>
  <section class="mt-5">
    <h3 class="text-lg font-bold mb-3">{{ $t("Pages You Liked") }}</h3>
    <div>
      <div v-if="pages.length > 0" class="flex flex-col gap-2">
        <PageCard v-for="page in pages" :key="page.id" :page="page" />
      </div>

      <div v-else>
        <EmptyList />
      </div>
    </div>
  </section>
</template>

<script setup>
import EmptyList from "../EmptyList.vue";
import PageCard from "./PageCard.vue";

const props = defineProps({
  pages: {
    type: Array,
    required: true,
  },
});
</script>
