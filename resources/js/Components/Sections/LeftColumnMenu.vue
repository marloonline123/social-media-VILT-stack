<template>
    <div>
        <ul class="list-none flex flex-col gap-1">
            <NavIitem link="#" icon="fa-solid fa-rss">{{ $t('Feeds') }}</NavIitem>
            <NavIitem link="#" icon="fa-solid fa-user-group">{{ $t('Friends') }}</NavIitem>
            <NavIitem link="#" icon="fa-regular fa-flag">{{ $t('Pages') }}</NavIitem>
            <NavIitem link="#" icon="fa-solid fa-users-rectangle">{{ $t('Groups') }}</NavIitem>
        </ul>
    </div>
</template>

<script setup>
import NavIitem from '../NavIitem.vue';

</script>
