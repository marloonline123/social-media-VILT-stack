<template>
  <Head title="Profile" />
  <AppLayout>
    <Card class="md:w-[90%] lg:w-[80%] mx-auto h-full overflow-hidden rounded-lg">
      <!-- Cover & Profile Image -->
      <div class="relative">
        <div class="h-[200px] w-full">
          <img :src="user.cover" class="w-full h-full object-cover" />
        </div>
        <div
          class="absolute -bottom-[50px] md:-bottom-[50px] left-8 w-[120px] h-[120px] md:w-[150px] md:h-[150px] rounded-full border-4 border-white"
        >
          <img
            class="w-full h-full object-cover rounded-full"
            :src="user.avatar"
            alt=""
          />
        </div>
      </div>

      <!-- Profile Info -->
      <div class="mt-16 flex flex-col md:flex-row justify-between items-center px-6">
        <div class="text-center md:text-left">
          <p class="text-2xl font-bold">{{ user.name }}</p>
          <p class="text-sm text-gray-500">@{{ user.username }}</p>
          <p class="text-sm mt-2 whitespace-pre-line text-gray-700 max-w-[300px]">
            {{ user.bio }}
          </p>
        </div>

        <!-- 📊 User Stats (Static Data) -->
        <Stats :user="user" />

        <!-- Follow/Edit Buttons -->
        <div class="mt-4 md:mt-0">
          <Link
            v-if="user.id === $page.props.auth?.user?.id"
            :href="route('profile.edit', user.username)"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
          >
            Edit Profile
          </Link>
          <div v-else>
            <Link
              v-if="!user.isFollowing"
              :href="route('profile.follow-toggle', user.username)"
              type="button"
              method="post"
              class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
            >
              Follow
            </Link>
            <Link
              v-if="user.isFollowing"
              :href="route('profile.follow-toggle', user.username)"
              type="button"
              method="post"
              class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition"
            >
              Unfollow
            </Link>
          </div>
        </div>
      </div>

      <hr class="my-5" />

      <!-- Tabs Navigation -->
      <div class="px-6">
        <div id="tabs" class="flex items-center overflow-x-auto pb-2">
          <TapButton @click="activeTap = 'posts'" :activeTap="activeTap" text="posts"
            >Posts</TapButton
          >
          <TapButton
            @click="activeTap = 'followers'"
            :activeTap="activeTap"
            text="followers"
            >Followers</TapButton
          >
          <TapButton
            @click="activeTap = 'following'"
            :activeTap="activeTap"
            text="following"
            >Following</TapButton
          >
          <TapButton @click="activeTap = 'gallery'" :activeTap="activeTap" text="gallery"
            >Gallery</TapButton
          >
        </div>
      </div>
    </Card>

    <!-- Tab Content -->
    <div class="md:w-[90%] lg:w-[80%] mx-auto mt-3">
      <PostsTap v-if="activeTap === 'posts'" :user="user" :posts="posts" />
      <FollowersTap
        v-if="activeTap === 'followers'"
        :user="user"
        :followers="followers"
      />
      <FollowingTap
        v-if="activeTap === 'following'"
        :user="user"
        :followings="followings"
      />
      <GalleryTap
        v-if="activeTap === 'gallery'"
        :user="user"
        :attachments="attachments"
      />
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import { Head, Link } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import PostsTap from "@/Pages/Profile/Partials/ProfileTaps/PostsTap.vue";
import FollowersTap from "@/Pages/Profile/Partials/ProfileTaps/FollowersTap.vue";
import FollowingTap from "@/Pages/Profile/Partials/ProfileTaps/FollowingTap.vue";
import GalleryTap from "@/Pages/Profile/Partials/ProfileTaps/GalleryTap.vue";
import { useStore } from "vuex";
import TapButton from "@/Components/Groups/Taps/Partials/TapButton.vue";
import Stats from "./Partials/Stats.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  followers: {
    type: Object,
    required: true,
  },
  followings: {
    type: Object,
    required: true,
  },
  attachments: {
    type: Object,
    required: true,
  },
});
const store = useStore();
const activeTap = ref("posts");
const user = computed(() => props.user.data);
const followers = computed(() => props.followers.data);
const followings = computed(() => props.followings.data);
const attachments = computed(() => props.attachments.data);
store.commit("Posts/clearPosts");
store.dispatch("Posts/fetchUserPosts", { username: user.value.username });
const posts = computed(() => store.state.Posts.posts);
console.log("attachments", attachments.value);
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
