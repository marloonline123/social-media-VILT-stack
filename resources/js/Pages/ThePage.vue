<template>
  <Head title="Page Details" />
  <AppLayout>
    <Card
      style="padding: 0"
      class="md:w-[90%] lg:w-[80%] mx-auto h-full overflow-hidden rounded-lg"
    >
      <ValidationError :for="form.errors.avatar" class="mb-2" />
      <ValidationError :for="form.errors.cover" class="mb-2" />
      <div>
        <div class="relative">
          <div class="h-[200px] w-full group">
            <input
              v-if="page.is_admin"
              type="file"
              id="cover"
              class="hidden"
              accept="image/*"
              @change="uploadCover"
            />
            <label class="cursor-pointer" for="cover">
              <Image
                :src="page.cover"
                class="w-full h-full object-cover"
                alt="Page Cover Image"
              />
              <div
                v-show="page.is_admin"
                class="absolute cursor-pointer inset-0 bg-black/30 hidden group-hover:block transition-all duration-300"
              >
                <div class="flex justify-center items-center w-full h-full">
                  <i class="fa-solid fa-camera text-4xl text-white"></i>
                </div>
              </div>
            </label>
          </div>
          <div
            class="group absolute -bottom-[50px] left-8 rtl:right-8 w-[120px] h-[120px] md:w-[150px] md:h-[150px] rounded-full border-4 border-white"
          >
            <input
              v-if="page.is_admin"
              type="file"
              id="avatar"
              class="hidden"
              accept="image/*"
              @change="uploadAvatar"
            />
            <label class="cursor-pointer" for="avatar">
              <Image
                class="w-full h-full object-cover rounded-full"
                :src="page.avatar"
                alt="Page Avatar Image"
              />
              <div
                v-show="page.is_admin"
                class="absolute cursor-pointer inset-0 bg-black/30 hidden group-hover:block rounded-full transition-all duration-300"
              >
                <div class="flex justify-center items-center w-full h-full">
                  <i class="fa-solid fa-camera text-4xl text-white"></i>
                </div>
              </div>
            </label>
          </div>
        </div>

        <div class="mt-2 flex items-center flex-wrap mx-5">
          <div
            class="flex flex-col md:flex-row justify-between gap-3 items-start flex-grow mt-12"
          >
            <div>
              <p class="text-lg md:text-2xl font-bold">{{ page.name }}</p>
              <p
                class="text-sm whitespace-pre-line mt-2 text-slate-700 dark:text-slate-200"
              >
                {{ page.about }}
              </p>
            </div>

            <div>
              <div class="flex space-x-6">
                <div class="text-center">
                  <p class="text-xl font-bold">{{ page.posts_count }}</p>
                  <p class="text-sm text-gray-500">Posts</p>
                </div>
                <div class="text-center">
                  <p class="text-xl font-bold">{{ page.followers_count }}</p>
                  <p class="text-sm text-gray-500">Followers</p>
                </div>
              </div>
            </div>

            <div class="flex md:flex-col gap-2">
              <div v-if="page.is_admin" class="flex md:flex-col gap-2">
                <EditPage :page="page" />
                <DeletePage :page="page" />
              </div>
              <FollowUnfollowPage :page="page" />
            </div>
          </div>
        </div>

        <hr class="my-5 md:mt-10" />

        <div class="px-3">
          <div id="tabs" class="flex items-center overflow-x-auto pb-2">
            <TapButton @click="activeTap = 'posts'" text="posts" :activeTap="activeTap">
              {{ $t("Posts") }}
            </TapButton>
            <TapButton
              @click="activeTap = 'followers'"
              text="followers"
              :activeTap="activeTap"
            >
              {{ $t("Followers") }}
            </TapButton>
            <TapButton
              @click="activeTap = 'gallery'"
              text="gallery"
              :activeTap="activeTap"
              >{{ $t("Gallery") }}
            </TapButton>
          </div>
        </div>
      </div>
    </Card>

    <Card
      class="mt-2 bg-transparent md:w-[90%] lg:w-[80%] mx-auto shadow-none border-none"
      style="padding: 0; background-color: transparent"
    >
      <div class="mt-2">
        <PostsTap v-if="activeTap === 'posts'" :posts="posts" :page="page" />
        <FollowersTap
          v-if="activeTap === 'followers'"
          :followers="followers"
          :page="page"
        />
        <GalleryTap
          v-if="activeTap === 'gallery'"
          :attachments="attachments"
          text="page"
        />
      </div>
    </Card>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import TapButton from "@/Components/Groups/Taps/Partials/TapButton.vue";
import Image from "@/Components/Image.vue";
import ValidationError from "@/Components/ValidationError.vue";
import { useToast } from "@/Utl/useToast";
import { useStore } from "vuex";
import FollowersTap from "@/Components/Pages/Taps/FollowersTap.vue";
import PostsTap from "@/Components/Pages/Taps/PostsTap.vue";
import EditPage from "@/Components/Pages/EditPage.vue";
import DeletePage from "@/Components/Pages/DeletePage.vue";
import GalleryTap from "@/Components/Sections/GalleryTap.vue";
import FollowUnfollowPage from "@/Components/Pages/FollowUnfollowPage.vue";

const props = defineProps({
  page: {
    type: Object,
    required: true,
  },
  followers: {
    type: Object,
    required: true,
  },
  attachments: {
    type: Object,
    required: true,
  },
});

const page = computed(() => props.page.data);
const followers = computed(() => props.followers.data);
const attachments = computed(() => props.attachments.data);
const activeTap = ref("posts");
const { showToast } = useToast();
const store = useStore();
const form = useForm({
  avatar: null,
  cover: null,
  _method: "PUT",
});
store.commit("Posts/clearPosts");
store.dispatch("Posts/fetchPagePosts", { id: page.value.id });
const posts = computed(() => store.state.Posts.posts);

console.log("posts", posts.value);

const uploadAvatar = (event) => {
  form.avatar = event.target.files[0];
  form.post(route("pages.upload-avatar", page.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      showToast("Avatar uploaded successfully");
    },
    onError: () => {
      form.reset();
      showToast("Avatar upload failed", "error");
    },
  });
};

const uploadCover = (event) => {
  form.cover = event.target.files[0];
  form.post(route("pages.upload-cover", page.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      showToast("Cover uploaded successfully");
    },
    onError: () => {
      form.reset();
      showToast("Cover upload failed", "error");
    },
  });
};
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
