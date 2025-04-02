<template>
  <div>
    <div class="">
      <IconButton
        @click="openSearch"
        class="text-xl"
        icon="fa-solid fa-magnifying-glass"
      />
    </div>

    <div
      v-show="searching"
      class="fixed p-3 top-0 left-0 w-full h-full bg-white dark:bg-slate-800 z-50 overflow-y-auto"
    >
      <div class="flex items-center gap-2">
        <div class="flex-grow">
          <TextInput
            :placeholder="$t('Search Something...')"
            icon="fa-solid fa-magnifying-glass"
            v-model="form.search"
            @input="search"
            focus
          />
        </div>
        <button @click="closeSearch">cancel</button>
      </div>

      <div v-show="isLoading" class="mt-5">Loading...</div>

      <div v-show="form.search" class="mt-5">
        <div class="flex flex-col md:flex-row gap-3">
          <div class="border-2 rounded-md p-2 w-full md:w-1/2">
            <h3 class="text-2xl font-bold">Users</h3>
            <div class="mt-3">
              <div v-if="data.usersData.length > 0">
                <UserCard v-for="user in data.usersData" :key="user.id" :user="user" />
              </div>
              <p v-else class="text-center">No search results for groups</p>
            </div>
          </div>
          <div class="border-2 rounded-md p-2 w-full md:w-1/2">
            <h3 class="text-2xl font-bold">Groups</h3>
            <div class="mt-3">
              <div v-if="data.groupsData.length > 0">
                <GroupItem
                  v-for="group in data.groupsData"
                  :key="group.id"
                  :group="group"
                />
              </div>
              <p v-else class="text-center">No search results for groups</p>
            </div>
          </div>
        </div>

        <div class="border-2 rounded-md p-2 w-full mt-3">
          <h3 class="text-2xl font-bold">Posts</h3>
          <div class="mt-3">
            <div v-if="data.postsData.length > 0">
              <PostSearchCard
                v-for="post in data.postsData"
                :key="post.id"
                :post="post"
              />
            </div>
            <p v-else class="text-center">No search results for posts</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import TextInput from "../TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import GroupItem from "../Groups/GroupItem.vue";
import UserCard from "../Sections/UserCard.vue";
import PostSearchCard from "./PostSearchCard.vue";
import IconButton from "../IconButton.vue";

const isLoading = ref(false);
const searching = ref(false);
const data = ref({
  groupsData: [],
  usersData: [],
  postsData: [],
});
const form = useForm({
  search: "",
});

let debounceTimeout = null;

const search = () => {
  if (!form.search) return;

  if (debounceTimeout) {
    clearTimeout(debounceTimeout);
  }

  debounceTimeout = setTimeout(async () => {
    isLoading.value = true;
    const response = await axios.get(route("search", { term: form.search }));
    const responseData = response.data;
    data.value.groupsData = responseData.groupsData;
    data.value.usersData = responseData.usersData;
    data.value.postsData = responseData.postsData;
    console.log(response);
    isLoading.value = false;
  }, 1000);
};

const openSearch = () => (searching.value = true);
const closeSearch = () => {
  searching.value = false;
  form.reset();
};
</script>
