<template>
  <div>
    <Dropdown align="right" width="48">
      <template #trigger>
        <span class="inline-flex rounded-md">
          <button
            type="button"
            class="inline-flex items-center rounded-md border border-transparent bg-transparent p-1 text-sm font-medium leading-4 transition duration-150 ease-in-out focus:outline-none"
          >
            <!-- {{ $page.props.auth.user.name }} -->
            <div class="w-8 h-8 rounded-full overflow-hidden p-[1px] border-2 border-blue-500">
              <img
                class="w-full h-full rounded-full object-cover cursor-pointer"
                :src="'/storage/' + user.avatar"
                alt="user Avatar"
              />
            </div>

            <svg
              class="-me-0.5 h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </span>
      </template>

      <template #content>
        <DropdownLink :href="route('profile.show', user.username)">
          {{ $t("Profile") }}
        </DropdownLink>
        <DropdownLink :href="route('logout')" method="post" as="button">
          {{ $t("Logout") }}
        </DropdownLink>
      </template>
    </Dropdown>
  </div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import Dropdown from "../Dropdown.vue";
import DropdownLink from "../DropdownLink.vue";
import { computed } from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>