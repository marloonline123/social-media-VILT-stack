<template>
    <section class="bg-white dark:bg-slate-700 p-4 w-full shadow-md rounded-md ">
        <div>
            <Title>{{ $t('Stories') }}</Title>
        </div>
        <div class="grid grid-cols-5 gap-2 mt-2">
            <StoryCard bgImage="https://img.freepik.com/premium-photo/close-up-robot-with-paint-splatter-it-generative-ai_955884-11037.jpg"
                image="https://img.freepik.com/premium-photo/close-up-robot-with-paint-splatter-it-generative-ai_955884-11037.jpg" />
            <StoryCard bgImage="https://img.freepik.com/premium-photo/close-up-robot-with-paint-splatter-it-generative-ai_955884-11037.jpg"
                image="https://img.freepik.com/premium-photo/close-up-robot-with-paint-splatter-it-generative-ai_955884-11037.jpg" />
            <StoryCard bgImage="https://img.freepik.com/premium-photo/close-up-robot-with-paint-splatter-it-generative-ai_955884-11037.jpg"
                image="https://img.freepik.com/premium-photo/close-up-robot-with-paint-splatter-it-generative-ai_955884-11037.jpg" />
            <StoryCard bgImage="https://img.freepik.com/premium-photo/close-up-robot-with-paint-splatter-it-generative-ai_955884-11037.jpg"
                image="https://img.freepik.com/premium-photo/close-up-robot-with-paint-splatter-it-generative-ai_955884-11037.jpg" />
            <StoryCard bgImage="https://img.freepik.com/premium-photo/close-up-robot-with-paint-splatter-it-generative-ai_955884-11037.jpg"
                image="https://img.freepik.com/premium-photo/close-up-robot-with-paint-splatter-it-generative-ai_955884-11037.jpg" />
        </div>
    </section>
</template>

<script setup>
import Title from '../Title.vue';
import StoryCard from '../StoryCard.vue';

</script>