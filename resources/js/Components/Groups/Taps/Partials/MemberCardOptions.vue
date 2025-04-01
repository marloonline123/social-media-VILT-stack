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
        <ChangeMemberRole @close-dropdown="close" :member="member" />
        <DeleteMember @close-dropdown="close" :member="member" />
      </template>
    </Dropdown>
  </div>
</template>

<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import IconButton from "@/Components/IconButton.vue";
import ChangeMemberRole from "./ChangeMemberRole.vue";
import DeleteMember from "./DeleteMember.vue";

defineProps({
  member: {
    type: Object,
    required: true,
  },
});
</script>
