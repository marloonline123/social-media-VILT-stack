<template>
  <div class="flex gap-3 relative">
    <div class="w-full md:w-3/5">
      <div>
        <CreatePost :page="page" />
      </div>

      <div class="mt-3">
        <Transition name="fade">
          <UploadingPost />
        </Transition>
      </div>

      <section class="mt-3">
        <div v-if="posts.length > 0">
          <TransitionGroup class="flex flex-col gap-3" name="fade" tag="div">
            <PostCard v-for="post in posts" :key="post.id" :post="post" />
          </TransitionGroup>
        </div>
        <div v-else>
          <EmptyList />
        </div>
      </section>

      <!-- Load More -->
      <LoadMorePosts :posts="posts" type="page" :page="page" />
    </div>
    <div class="hidden md:block w-2/5 sticky top-20 h-[calc(100vh-20px)] overflow-y-auto">
      <div class="">
        <Card>
          <div class="mb-3">
            <h3 class="text-lg font-bold">Page Admin</h3>
          </div>
          <div class="flex flex-col gap-3">
            <AdminGroupCard v-for="admin in [page.user]" :key="admin.id" :admin="admin" />
          </div>
        </Card>
      </div>
    </div>
  </div>
</template>

<script setup>
import Card from "@/Components/Card.vue";
import EmptyList from "@/Components/EmptyList.vue";
import AdminGroupCard from "@/Components/Groups/Taps/Partials/AdminGroupCard.vue";
import CreatePost from "@/Components/Posts/CreatePost.vue";
import PostCard from "@/Components/Posts/PostCard.vue";
import UploadingPost from "@/Components/Posts/UploadingPost.vue";
import LoadMorePosts from "@/Components/Sections/LoadMorePosts.vue";

defineProps({
  posts: {
    type: Array,
    required: true,
  },
  page: {
    type: Object,
    required: true,
  },
});
</script>
