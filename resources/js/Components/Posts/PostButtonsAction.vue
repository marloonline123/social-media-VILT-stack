<template>
    <div class="mt-3 flex items-center justify-between border-y dark:border-slate-600 py-2">
        <!-- Like Button -->
        <button
            class="group text-2xl flex-1 flex items-center justify-center gap-1.5 hover:bg-slate-100 dark:hover:bg-slate-600 px-2 py-1.5 rounded-md transition-all duration-200">
            <i class="fa-regular fa-heart py-1 transition-colors"></i>
            <span
                class="text-xs font-medium text-slate-600 dark:text-slate-300 group-hover:text-slate-800 dark:group-hover:text-slate-100">
                Like
            </span>
        </button>

        <!-- Comment Button -->
        <button
            class="group text-2xl flex-1 flex items-center justify-center gap-1.5 hover:bg-slate-100 dark:hover:bg-slate-600 px-2 py-1.5 rounded-md transition-all duration-200">
            <div class="relative">
                <i class="fa-regular fa-comment transition-colors"></i>
                <!-- <div class="absolute -top-1 -right-1 w-2 h-2 bg-sky-400 rounded-full animate-pulse"></div> -->
            </div>
            <span
                class="text-xs font-medium text-slate-600 dark:text-slate-300 group-hover:text-slate-800 dark:group-hover:text-slate-100">
                Comment
            </span>
        </button>

        <!-- Share Button -->
        <button
            class="group text-2xl flex-1 flex items-center justify-center gap-1.5 hover:bg-slate-100 dark:hover:bg-slate-600 px-2 py-1.5 rounded-md transition-all duration-200">
            <div class="relative">
                <i class="fa-regular fa-paper-plane transition-colors"></i>
                <!-- <div class="absolute -top-1 -right-1 w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div> -->
            </div>
            <span
                class="text-xs font-medium text-slate-600 dark:text-slate-300 group-hover:text-slate-800 dark:group-hover:text-slate-100">
                Share
            </span>
        </button>
    </div>
</template>