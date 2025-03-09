<template>
  <div
    class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-md rounded-xl px-5 py-2 transition-all hover:shadow-lg"
  >
    <div class="flex items-start gap-2">
      <!-- Avatar -->
      <div
        class="h-12 w-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-300 dark:border-slate-600"
      >
        <img
          class="w-full h-full object-cover"
          src="https://media.istockphoto.com/id/183412466/photo/eastern-bluebirds-male-and-female.jpg?s=612x612&w=0&k=20&c=6_EQHnGedwdjM9QTUF2c1ce7cC3XtlxvMPpU5HAouhc="
          alt="User avatar"
        />
      </div>

      <!-- Post Content -->
      <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2">
            <Link
              href="#"
              class="text-base font-semibold text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400 transition"
            >
              Username
            </Link>
            <span class="text-xs text-gray-500 dark:text-slate-400">• 5 min ago</span>
          </div>
        </div>
        <p class="text-sm text-gray-800 dark:text-slate-200 leading-relaxed">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus, nemo!
        </p>

        <!-- Action Buttons -->
        <div class="mt-3 flex items-center gap-4 text-gray-500 dark:text-slate-400">
          <button class="flex items-center gap-1 text-sm hover:text-blue-500 transition">
            <i class="fa-regular fa-thumbs-up"></i> {{ $t("Like") }}
          </button>
          <button class="flex items-center gap-1 text-sm hover:text-blue-500 transition">
            <i class="fa-regular fa-comment"></i> {{ $t("Comment") }}
          </button>
          <button class="flex items-center gap-1 text-sm hover:text-blue-500 transition">
            <i class="fa-solid fa-share"></i> {{ $t("Share") }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
