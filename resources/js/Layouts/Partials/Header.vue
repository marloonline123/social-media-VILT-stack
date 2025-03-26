<template>
  <header
    class="bg-white h-[70px] fixed top-0 left-0 z-50 dark:bg-slate-700 shadow-md py-3 px-5 md:px-10 w-full flex items-center justify-between gap-5"
  >
    <Link :href="route('home')">
      <h1 class="text-4xl font-bold text-blue-500">{{ $t("Logo") }}</h1>
    </Link>
    <div class="flex justify-end md:justify-between items-center flex-grow">
      <div class="hidden md:block">
        <Search />
      </div>
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
        <LangSwitch />
        <IconButton @click="toggleTheme" icon="fa-solid fa-circle-half-stroke" />
        <MobileMenu />
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import NotificationsDropDown from "@/Components/Sections/NotificationsDropDown.vue";
import IconButton from "@/Components/IconButton.vue";
import { toggleTheme } from "@/theme";
import PrivateMessagesDropdown from "@/Components/Sections/PrivateMessagesDropdown.vue";
import ProfileDropdown from "@/Components/Sections/ProfileDropdown.vue";
import LangSwitch from "@/Components/Sections/LangSwitch.vue";
import { Link } from "@inertiajs/vue3";
import MobileMenu from "@/Components/Sections/MobileMenu.vue";
import Search from "@/Components/Sections/Search.vue";
import CreateDropdown from "@/Components/Sections/CreateDropdown.vue";

const search = ref("");
</script>
