<template>
    <div class="">
        <TextInput :placeholder="$t('Search Something...')" icon="fa-solid fa-magnifying-glass" v-model="search" />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import TextInput from '../TextInput.vue';


const search = ref("");
</script>