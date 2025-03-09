<template>
    <Card class="py-4">
        <div class="flex items-center gap-2" @click="openModal">
            <TextInput v-model="emptyModel" class="flex-grow" :placeholder="$t('What\'s on your mind')" />
            <IconButton class="text-lg" icon="fa-regular fa-paper-plane"></IconButton>
        </div>
    </Card>
</template>

<script setup>
import { ref } from 'vue';
import Card from '../Card.vue';
import TextInput from '../TextInput.vue';
import IconButton from '../IconButton.vue';

defineProps({
    openModal: {
        type: Function,
        required: true,
    },
});

const emptyModel = ref('')

</script>