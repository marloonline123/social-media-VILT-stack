<template>
  <div>
    <Dropdown align="right" width="48">
      <template #trigger>
        <span class="inline-flex rounded-md">
          <div class="relative">
            <IconButton icon="fa-solid fa-ellipsis-vertical" />
          </div>
        </span>
      </template>

      <template #content="{ close }">
        <EditPost @close-dropdown="close" :post="post" />
        <DeletePost @close-dropdown="close" :post="post" />
        <DropdownLink :href="route('posts.show', post.slug)" icon="fa-solid fa-eye">
          View
        </DropdownLink>
      </template>
    </Dropdown>
  </div>
</template>

<script setup>
import Dropdown from "../Dropdown.vue";
import DropdownLink from "../DropdownLink.vue";
import IconButton from "../IconButton.vue";
import DeletePost from "./DeletePost.vue";
import EditPost from "./EditPost.vue";

const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
});
</script>
