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
                <EditComment @close-dropdown="close" :comment="comment" />
                <DeleteComment @close-dropdown="close" :comment="comment" />
            </template>
        </Dropdown>
    </div>
</template>

<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import IconButton from '@/Components/IconButton.vue';
import DeleteComment from './DeleteComment.vue';
import EditComment from './EditComment.vue';

defineProps({
    comment: {
        type: Object,
        required: true,
    },
});

</script>