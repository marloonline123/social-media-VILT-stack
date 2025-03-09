<template>
    <div class="">
        <div dir="ltr" :style="`background-image: url(${bgImage})`" :class="`relative bg-cover group bg-center h-[150px] rounded-md shadow-md border-2 hover:border-blue-500 duration-200 cursor-pointer overflow-hidden`">
            <div class="absolute top-0 left-0 w-full h-full bg-slate-900/30 group-hover:bg-slate-900/20"></div>
            <div class="absolute bottom-1 left-2 flex items-center gap-[2px]">
                <img class="w-4 h-4 rounded-full object-cover" :src="image" alt="">
                <Title class="text-[8px] text-white">My Username</Title>
            </div>
        </div>
    </div>
</template>

<script setup>
import Title from './Title.vue';

defineProps({
    bgImage: {
        type: String,
        required: true
    },
    image: {
        type: String,
        required: true
    }
})

</script>