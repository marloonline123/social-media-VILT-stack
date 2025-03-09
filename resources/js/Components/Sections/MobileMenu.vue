<template>
    <div>
        <IconButton @click="menuOpened = !menuOpened" icon="fa-solid fa-bars" />

        <Transition name="fade">
            <div v-if="menuOpened" @click="menuOpened = false" class="fixed top-0 left-0 w-full h-full bg-black/50 dark:bg-slate-900/50 z-40"></div>
        </Transition>
        
        <Transition name="side">
            <div v-if="menuOpened" class="fixed top-0 right-0 ltr:left-0 w-[300px] shadow h-full bg-white dark:bg-slate-700 z-50">
                <div class="p-3">
                    <IconButton @click="menuOpened = !menuOpened" icon="fa-solid fa-times" />
                </div>
                <div class="mt-5 px-5 md:hidden">
                    <Search />
                </div>
                <div class="mt-5 px-5">
                    <LeftColumnMenu />
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import IconButton from '../IconButton.vue';
import LeftColumnMenu from './LeftColumnMenu.vue';
import Search from './Search.vue';

const menuOpened = ref(false);

</script>
