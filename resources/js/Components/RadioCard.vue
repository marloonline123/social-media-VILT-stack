<script setup>
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps({
  checked: {
    type: [Array, Boolean],
    required: true,
  },
  value: {
    default: null,
  },
});

const proxyChecked = computed({
  get() {
    return props.checked;
  },

  set(val) {
    emit("update:checked", val);
  },
});
</script>

<template>
  <div>
    <input
      v-model="form.gender"
      class="peer hidden"
      type="radio"
      id="gender-female"
      name="gender"
      value="female"
    />
    <label
      for="gender-female"
      class="flex items-center gap-2 cursor-pointer border-2 peer-checked:ring-2 peer-checked:ring-blue-500 rounded-md py-2 px-4 bg-slate-100 dark:bg-slate-700 transition"
    >
      <span>{{ $t("Female") }}</span>
    </label>
  </div>
</template>
