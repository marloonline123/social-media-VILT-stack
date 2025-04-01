<template>
  <div>
    <div v-if="loading" class="text-center my-4">Loading more posts...</div>
    <div id="loadMore" ref="loadMoreTrigger"></div>
  </div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, watchEffect, onMounted } from "vue";
import { useStore } from "vuex";

const props = defineProps({
  posts: {
    type: Array,
    required: true,
  },
  type: {
    type: String,
    default: "home-posts",
  },
  group: {
    type: Object,
    default: null,
  },
});

const store = useStore();
const user = usePage().props.auth.user;
const offset = ref(10);
const loading = ref(false);
const loadMoreTrigger = ref(null);

const loadMore = async () => {
  if (loading.value) return;

  loading.value = true;

  if (props.type === "group") {
    await store.dispatch("Posts/fetchGroupPosts", {
      id: props.group.id,
      offset: offset.value,
    });
  } else if (props.type === "user") {
    await store.dispatch("Posts/fetchUserPosts", {
      username: user.username,
      offset: offset.value,
    });
  } else {
    await store.dispatch("Posts/fetchPosts", { offset: offset.value });
  }

  offset.value += 10;
  loading.value = false;
};

onMounted(() => {
  if (!loadMoreTrigger.value) return;

  const observer = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting && !loading.value) {
        loadMore();
      }
    },
    { rootMargin: "100px" }
  );

  observer.observe(loadMoreTrigger.value);
});

watchEffect(() => {
  if (!loadMoreTrigger.value || props.posts.length === 0) return;

  const observer = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting && !loading.value) {
        loadMore();
      }
    },
    { rootMargin: "100px" }
  );

  observer.observe(loadMoreTrigger.value);
});
</script>
