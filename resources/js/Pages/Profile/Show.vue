<template>
  <Head title="Profile" />
  <AppLayout>
    <Card style="padding: 0;" class="md:w-[80%] mx-auto h-full overflow-hidden rounded-lg">
      <div>
        <div class="relative">
          <div class="h-[200px] w-full">
            <img
              :src=" '/storage/' + user.cover_image ?? 'https://addcovers.com/covers/anubgendls898ni.jpg'"
              class="w-full h-full object-cover"
            />
          </div>
          <div
            class="absolute -bottom-[50px] md:-bottom-[100px] left-8 rtl:right-8 w-[120px] h-[120px] md:w-[150px] md:h-[150px] rounded-full border-4 border-white"
          >
            <img
              class="w-full h-full object-cover rounded-full"
              :src="'/storage/' + user.avatar"
              alt=""
            />
          </div>
        </div>

        <div class="mt-2 flex items-center flex-wrap mx-5">
          <div class="w-full md:w-[calc(2rem+150px)]"></div>
          <div class="flex justify-between items-start flex-grow mt-12 md:mt-0">
            <div>
              <p class="text-2xl font-bold">{{ user.name }}</p>
              <p class="text-sm text-slate-500 dark:text-slate-400">@{{ user.username }}</p>
              <p class="text-sm whitespace-pre-line mt-2 text-slate-700 dark:text-slate-200">{{ user.bio }}</p>
            </div>
            <Link v-if="user.id === $page.props.auth?.user?.id" :href="route('profile.edit', user.username)" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 duration-200">
              {{ $t('Edit Profile') }}
            </Link>
          </div>
        </div>

        <hr class="my-5 md:mt-10" />

        <div class="px-3">
          <div id="tabs" class="flex items-center overflow-x-auto pb-2">
            <button @click="activeTap = 'about'" class="px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600" :class="{ 'border-b-2 border-b-blue-500 text-blue-500': activeTap === 'about' }">{{ $t('About') }}</button>
            <button @click="activeTap = 'posts'" class="px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600" :class="{ 'border-b-2 border-b-blue-500 text-blue-500': activeTap === 'posts' }">{{ $t('Posts') }}</button>
            <button @click="activeTap = 'followers'" class="px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600" :class="{ 'border-b-2 border-b-blue-500 text-blue-500': activeTap === 'followers' }">{{ $t('Followers') }}</button>
            <button @click="activeTap = 'following'" class="px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600" :class="{ 'border-b-2 border-b-blue-500 text-blue-500': activeTap === 'following' }">{{ $t('Following') }}</button>
            <button @click="activeTap = 'photos'" class="px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600" :class="{ 'border-b-2 border-b-blue-500 text-blue-500': activeTap === 'photos' }">{{ $t('Photos') }}</button>
          </div>

          <div class="mt-5 px-5">
            <AboutTap v-if="activeTap === 'about'" />
            <PostsTap v-if="activeTap === 'posts'" />
            <FollowersTap v-if="activeTap === 'followers'" />
            <FollowingTap v-if="activeTap === 'following'" />
            <PhotosTap v-if="activeTap === 'photos'" />
          </div>
        </div>
      </div>
    </Card>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import AboutTap from "@/Components/Sections/ProfileTaps/AboutTap.vue";
import PostsTap from "@/Components/Sections/ProfileTaps/PostsTap.vue";
import FollowersTap from "@/Components/Sections/ProfileTaps/FollowersTap.vue";
import FollowingTap from "@/Components/Sections/ProfileTaps/FollowingTap.vue";
import PhotosTap from "@/Components/Sections/ProfileTaps/PhotosTap.vue";

const { user } = defineProps({
  user: {
    type: Object,
    required: true,
  },
});
const activeTap = ref("about");

</script>

<style scoped>
#tabs::-webkit-scrollbar {
  height: 5px;
  transition: all 0.3s;
}

#tabs::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.2);
  border-radius: 5px;
  transition: background 0.3s;
}

#tabs:hover::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.5);
}

</style>