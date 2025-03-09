<template>
    <div>
        <Dropdown align="right" width="48">
            <template #trigger>
                <span class="inline-flex rounded-md">
                    <div class="relative">
                        <IconButton icon="fa-regular fa-bell" />
                        <span class="absolute top-[3px] right-[3px] w-2 h-2 bg-blue-500 rounded-full"></span>
                    </div>
                </span>
            </template>

            <template #content>
                <!-- <DropdownLink :href="route('profile.edit')">
                    Profile
                </DropdownLink> -->
                <DropdownLink :href="route('logout')" method="post" as="button">
                    Log Out
                </DropdownLink>
            </template>
        </Dropdown>
    </div>
</template>

<script setup>
import Dropdown from '../Dropdown.vue';
import DropdownLink from '../DropdownLink.vue';
import IconButton from '../IconButton.vue';

</script>