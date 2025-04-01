<template>
  <section class="mt-4">
    <h3 class="text-lg font-bold mb-2">{{ $t("Groups") }}</h3>
    <div>
      <div v-if="groups.length > 0" class="flex flex-col">
        <GroupItem v-for="group in groups" :key="group.id" :group="group" />
      </div>
      <div v-else>
        <EmptyList />
      </div>
    </div>
  </section>
</template>

<script setup>
import EmptyList from "../EmptyList.vue";
import GroupItem from "./GroupItem.vue";
const props = defineProps({
  groups: {
    type: Array,
    required: true,
  },
});

console.log("Groups:", props.groups);
</script>
