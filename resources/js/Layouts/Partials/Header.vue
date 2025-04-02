<template>
  <header
    class="bg-white h-[70px] fixed top-0 left-0 z-50 dark:bg-slate-700 shadow-md py-3 px-5 md:px-10 w-full flex items-center justify-between gap-5"
  >
    <Link :href="route('home')">
      <!-- <h1 class="text-4xl font-bold text-blue-500">{{ $t("Logo") }}</h1> -->
      <div class="">
        <Image :src="'/images/logo.png'" class="w-[150px]" />
      </div>
    </Link>
    <!-- <div class="flex justify-end md:justify-between items-center flex-grow">
      <div class="hidden md:block">
        <Search />
      </div> -->

    <div class="flex items-center gap-3">
      <div v-if="$page.props.auth.user" class="flex items-center gap-3">
        <CreateDropdown />
        <PrivateMessagesDropdown />
        <NotificationsDropDown />
        <ProfileDropdown />
      </div>
      <div v-else>
        <Link :href="route('login')">
          <IconButton class="font-normal">{{ $t("Login") }}</IconButton>
        </Link>
        <Link :href="route('register')">
          <IconButton class="font-normal">{{ $t("Register") }}</IconButton>
        </Link>
      </div>
      <Search />
      <LangSwitch class="hidden md:block" />
      <IconButton
        class="hidden md:block"
        @click="toggleTheme"
        icon="fa-solid fa-circle-half-stroke"
      />
      <MobileMenu />
    </div>

    <!-- </div> -->
  </header>
</template>

<script setup>
import { ref } from "vue";
import NotificationsDropDown from "@/Components/Sections/NotificationsDropDown.vue";
import IconButton from "@/Components/IconButton.vue";
import { toggleTheme } from "@/theme";
import PrivateMessagesDropdown from "@/Components/Sections/PrivateMessagesDropdown.vue";
import ProfileDropdown from "@/Components/Sections/ProfileDropdown.vue";
import LangSwitch from "@/Components/Sections/LangSwitch.vue";
import { Link } from "@inertiajs/vue3";
import MobileMenu from "@/Components/Sections/MobileMenu.vue";
import Search from "@/Components/Search/Search.vue";
import CreateDropdown from "@/Components/Sections/CreateDropdown.vue";
import Image from "@/Components/Image.vue";

const search = ref("");
</script>
