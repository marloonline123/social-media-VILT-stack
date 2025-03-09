
<template>
    <section class="mt-5">
        <h3 class="text-lg font-bold mb-3">{{ $t('Pages You Liked') }}</h3>
        <div>
            <div class="flex flex-col gap-2">
                <CardItem image="https://www.powertrafic.fr/wp-content/uploads/2023/04/image-ia-exemple.png"
                    title="Enhance After" desc="Enhance your website in 5 minutes" link="#" />
                <CardItem
                    image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgoRAM8VbTHTlFwB9v3BRa0ZlFUioRZH5lqQ&s"
                    title="Enhance After" desc="Enhance your website in 5 minutes" link="#" />
                <CardItem
                    image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTsYEgSVes2_xQlGAwUGXlPhDxLdsEzjLXBZ_hkoeEL1gvFuF0uasssWlRWee0iDtqXhTc&usqp=CAU"
                    title="Enhance After" desc="Enhance your website in 5 minutes" link="#" />
            </div>
        </div>
    </section>
</template>

<script setup>
import CardItem from '../CardItem.vue';

</script>