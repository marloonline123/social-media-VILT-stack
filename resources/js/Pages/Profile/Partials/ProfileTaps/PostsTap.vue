<template>
  <div class="">
    <div class="md:w-[600px]">
      <div v-if="user.id === $page.props.auth?.user?.id">
        <CreatePost />
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
      <LoadMorePosts :posts="posts" type="user" />
    </div>
  </div>
</template>

<script setup>
import EmptyList from "@/Components/EmptyList.vue";
import CreatePost from "@/Components/Posts/CreatePost.vue";
import PostCard from "@/Components/Posts/PostCard.vue";
import UploadingPost from "@/Components/Posts/UploadingPost.vue";
import LoadMorePosts from "@/Components/Sections/LoadMorePosts.vue";

defineProps({
  posts: {
    type: Array,
    required: true,
  },
  user: {
    type: Object,
    required: true,
  },
});
</script>
