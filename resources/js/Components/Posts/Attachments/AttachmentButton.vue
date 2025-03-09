<template>
    <div>
        <input @change="handleFileUpload" type="file" id="file" name="file" class="hidden" multiple />
        <label for="file" class="cursor-pointer">
            <span class="px-2 py-1 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-md duration-150">
                <i class="fa-solid fa-photo-film"></i>
            </span>
        </label>
    </div>
</template>

<script setup>

const emit = defineEmits(['handleFileUpload']);

const handleFileUpload = (event) => {
    emit('handleFileUpload', event);
};

</script>