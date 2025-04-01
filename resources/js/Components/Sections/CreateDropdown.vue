<template>
  <div>
    <Dropdown align="right" width="48">
      <template #trigger>
        <span class="inline-flex rounded-md">
          <div class="relative">
            <IconButton class="text-xl" icon="fa-regular fa-square-plus" />
            <!-- <span class="absolute top-[3px] right-[3px] w-2 h-2 bg-blue-500 rounded-full"></span> -->
          </div>
        </span>
      </template>

      <template #content="{ close }">
        <CreateGroupe @close-dropdown="close" />
        <DropdownLink :href="route('home')">{{ $t("Create Page") }}</DropdownLink>
      </template>
    </Dropdown>
  </div>
</template>

<script setup>
import Dropdown from "../Dropdown.vue";
import DropdownLink from "../DropdownLink.vue";
import CreateGroupe from "../Groups/CreateGroupe.vue";
import IconButton from "../IconButton.vue";
</script>
