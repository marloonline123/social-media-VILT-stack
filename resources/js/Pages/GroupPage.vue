<template>
  <Head title="Group Details" />
  <AppLayout>
    <AcceptInvitation :open-invitation="openInvitation" :group="group" />
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
              v-if="group.is_admin"
              type="file"
              id="cover"
              class="hidden"
              accept="image/*"
              @change="uploadCover"
            />
            <label class="cursor-pointer" for="cover">
              <Image
                :src="group.cover"
                class="w-full h-full object-cover"
                alt="Group Cover Image"
              />
              <div
                v-show="group.is_admin"
                class="absolute cursor-pointer inset-0 bg-black/30 hidden group-hover:block transition-all duration-300"
              >
                <div class="flex justify-center items-center w-full h-full">
                  <i class="fa-solid fa-camera text-4xl text-white"></i>
                </div>
              </div>
            </label>
          </div>
          <div
            class="group absolute -bottom-[50px] md:-bottom-[100px] left-8 rtl:right-8 w-[120px] h-[120px] md:w-[150px] md:h-[150px] rounded-full border-4 border-white"
          >
            <input
              v-if="group.is_admin"
              type="file"
              id="avatar"
              class="hidden"
              accept="image/*"
              @change="uploadAvatar"
            />
            <label class="cursor-pointer" for="avatar">
              <Image
                class="w-full h-full object-cover rounded-full"
                :src="group.avatar"
                alt="Group Avatar Image"
              />
              <div
                v-show="group.is_admin"
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
          <div class="w-full lg:w-[calc(2rem+150px)] bg-red-200"></div>
          <div
            class="flex flex-wrap justify-between gap-1 items-start flex-grow mt-12 md:mt-24 lg:mt-0"
          >
            <div>
              <p class="text-lg md:text-2xl font-bold">{{ group.name }}</p>
              <p
                class="text-sm whitespace-pre-line mt-2 text-slate-700 dark:text-slate-200"
              >
                {{ group.about }}
              </p>
            </div>

            <div class="flex flex-col gap-2">
              <InviteMember v-if="group.is_admin" :group="group" />
              <EditGroup
                v-if="group.user_id === $page.props.auth?.user?.id"
                :group="group"
              />
              <DeleteGroup
                v-if="group.user_id === $page.props.auth?.user?.id"
                :group="group"
              />
              <template v-if="group.user_id !== $page.props.auth?.user?.id">
                <div v-if="!group.joined">
                  <JoinGroup :group="group" />
                </div>
                <div v-else>
                  <LeaveGroup v-if="group.status == 'approved'" :group="group" />
                  <PrimaryButton v-else-if="group.status == 'pending'"
                    >Your Request is Pending</PrimaryButton
                  >
                  <PrimaryButton v-else-if="group.status == 'declined'"
                    >Your Request is Declined</PrimaryButton
                  >
                </div>
              </template>
            </div>
          </div>
        </div>

        <hr class="my-5 md:mt-10" />

        <div class="px-3">
          <div id="tabs" class="flex items-center overflow-x-auto pb-2">
            <TapButton @click="activeTap = 'posts'" text="posts" :activeTap="activeTap">
              {{ $t("Posts") }}
            </TapButton>
            <TapButton @click="activeTap = 'users'" text="users" :activeTap="activeTap">
              {{ $t("Members") }}
            </TapButton>
            <TapButton
              v-if="group.is_admin"
              @click="activeTap = 'pending-requests'"
              text="pending-requests"
              :activeTap="activeTap"
              >{{ $t("Pending Requests") }}
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
        <PostsTap
          v-if="activeTap === 'posts'"
          :group="group"
          :posts="posts"
          :members="members"
          :admins="admins"
        />
        <Users v-if="activeTap === 'users'" :group="group" :members="members" />
        <PendingRequests
          v-if="activeTap === 'pending-requests' && group.is_admin"
          :group="group"
          :requests="requests"
        />
        <FollowersTap v-if="activeTap === 'followers'" />
        <FollowingTap v-if="activeTap === 'following'" />
        <GalleryTap v-if="activeTap === 'gallery'" :attachments="attachments" />
      </div>
    </Card>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";
import FollowersTap from "@/Pages/Profile/Partials/ProfileTaps/FollowersTap.vue";
import FollowingTap from "@/Pages/Profile/Partials/ProfileTaps/FollowingTap.vue";
import TapButton from "@/Components/Groups/Taps/Partials/TapButton.vue";
import Image from "@/Components/Image.vue";
import ValidationError from "@/Components/ValidationError.vue";
import { useToast } from "@/Utl/useToast";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InviteMember from "@/Components/Groups/InviteMember.vue";
import AcceptInvitation from "@/Components/Groups/AcceptInvitation.vue";
import LeaveGroup from "@/Components/Groups/LeaveGroup.vue";
import JoinGroup from "@/Components/Groups/JoinGroup.vue";
import Users from "@/Components/Groups/Taps/Users.vue";
import PendingRequests from "@/Components/Groups/Taps/PendingRequests.vue";
import PostsTap from "@/Components/Groups/Taps/PostsTap.vue";
import { useStore } from "vuex";
import GalleryTap from "@/Components/Groups/Taps/GalleryTap.vue";
import EditGroup from "@/Components/Groups/EditGroup.vue";
import DeleteGroup from "@/Components/Groups/DeleteGroup.vue";

const props = defineProps({
  group: {
    type: Object,
    required: true,
  },
  members: {
    type: Object,
    required: true,
  },
  admins: {
    type: Object,
    required: true,
  },
  requests: {
    type: Object,
    required: true,
  },
  attachments: {
    type: Object,
    required: true,
  },
});

const group = computed(() => props.group.data);
const members = computed(() => props.members.data);
const requests = computed(() => props.requests.data);
const admins = computed(() => props.admins.data);
const attachments = computed(() => props.attachments.data);
const activeTap = ref("posts");
const { showToast } = useToast();
const openInvitation = ref(false);
const store = useStore();
const form = useForm({
  avatar: null,
  cover: null,
  _method: "PUT",
});
store.commit("Posts/clearPosts");
store.dispatch("Posts/fetchGroupPosts", { id: group.value.id });
const posts = computed(() => store.state.Posts.posts);

console.log("attachments", attachments.value);

const uploadAvatar = (event) => {
  form.avatar = event.target.files[0];
  form.post(route("groups.upload-avatar", group.value.slug), {
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
  form.post(route("groups.upload-cover", group.value.slug), {
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

onMounted(() => {
  if (group.value.invited) {
    openInvitation.value = true;
  }
});
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
