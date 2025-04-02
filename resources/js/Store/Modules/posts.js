import axios from "axios";

export default {
    namespaced: true,
    state: {
        posts: [],
    },
    getters: {
        posts(state) {
            return state.posts;
        },
    },
    mutations: {
        getPosts(state, posts) {
            state.posts.push(...posts);
        },

        clearPosts(state, posts) {
            state.posts = [];
        },

        updatePost(state, post) {
            if (state.posts.some((p) => p.id === post.id)) {
                state.posts = state.posts.map((p) => {
                    if (p.id === post.id) {
                        return post;
                    }
                    return p;
                });
            } else {
                state.posts.unshift(post);
            }
        },

        updatePostComment(state, comment) {
            const post = state.posts.find((p) => p.id === comment.post.id);
            if (post.comments.some((c) => c.id === comment.id)) {
                post.comments = post.comments.map((c) => {
                    if (c.id === comment.id) {
                        return comment;
                    }
                    return c;
                });
            } else {
                post.comments.unshift(comment);
            }
        },

        updatePostCommentReply(state, reply) {
            const post = state.posts.find((p) => p.id === reply.post.id);
            const comment = post.comments.find(
                (c) => c.id === reply.comment_id
            );
            if (comment.replies.some((r) => r.id === reply.id)) {
                comment.replies = comment.replies.map((r) => {
                    if (r.id === reply.id) {
                        return reply;
                    }
                    return r;
                });
            } else {
                comment.replies.unshift(reply);
            }
        },

        deletePost(state, id) {
            state.posts = state.posts.filter((post) => post.id !== id);
        },

        deletePostComment(state, { id, postId }) {
            const post = state.posts.find((p) => p.id === postId);
            post.comments = post.comments.filter((c) => c.id !== id);
        },

        deletePostCommentReply(state, { id, postId }) {
            const post = state.posts.find((p) => p.id === postId);
            post.comments = post.comments.filter(
                (c) => (c.replies = c.replies.filter((r) => r.id !== id))
            );
        },
    },
    actions: {
        async fetchPosts({ commit }, payload = { offset: 0 }) {
            try {
                const response = await axios.get(route("posts.index", { offset: payload.offset }));
                commit("getPosts", response.data.posts);
            } catch (error) {
                console.error("[ACTION] fetchPosts: Error fetching posts", error);
            }
        },
        async fetchSinglePost({ commit }, slug) {
            try {
                const response = await axios.get(
                    route("posts.single", slug)
                );
                commit("getPosts", [response.data.posts]);
            } catch (error) {
                console.error("[ACTION] fetchPosts: Error fetching posts", error);
            }
        },
        async fetchUserPosts({ commit }, payload = { username, offset: 0 }) {
            try {
                const response = await axios.get(
                    route("profile.posts", payload.username),
                    {
                        params: { offset: payload.offset },
                    }
                );
                commit("getPosts", response.data.posts);
            } catch (error) {
                console.error("[ACTION] fetchPosts: Error fetching posts", error);
            }
        },

        async fetchPagePosts({ commit }, { id, offset = 0 }) {
            await axios
                .get(route("pages.posts", id), {
                    params: { offset },
                })
                .then((response) => {
                    commit("getPosts", response.data.posts);
                });
        },

        async fetchGroupPosts({ commit }, { id, offset = 0 }) {
            await axios
                .get(route("groups.posts", id), {
                    params: { offset },
                })
                .then((response) => {
                    commit("getPosts", response.data.posts);
                });
        },

        async storeComment({ commit }, { postId, body }) {
            console.log("[ACTION] storeComment: Post ID=", postId);
            await axios
                .post(route("posts.comments.store", postId), { body })
                .then((response) => {
                    if (response.data.success) {
                        commit("updatePostComment", response.data.data);
                    }
                });
        },

        async storeCommentReply({ commit }, { id, body }) {
            await axios
                .post(route("comments.reply", id), { body })
                .then((response) => {
                    if (response.data.success) {
                        commit("updatePostCommentReply", response.data.data);
                    }
                });
        },

        async updateComment({ commit }, { id, body }) {
            console.log("[ACTION] updateComment: Comment ID=", id);
            await axios
                .post(route("comments.update", id), { body, _method: "PUT" })
                .then((response) => {
                    const comment = response.data.data;
                    if (response.data.success) {
                        if (comment.comment_id) {
                            commit("updatePostCommentReply", comment);
                        } else {
                            commit("updatePostComment", comment);
                        }
                    }
                });
        },

        async deletePost({ commit }, id) {
            await axios.delete(route("posts.destroy", id)).then((response) => {
                if (response.data.status) {
                    commit("deletePost", id);
                }
            });
        },

        async deletePostComment({ commit }, { id, postId, commentId }) {
            await axios
                .delete(route("comments.destroy", id))
                .then((response) => {
                    if (response.data.success) {
                        if (commentId) {
                            commit("deletePostCommentReply", {
                                id,
                                postId,
                                commentId,
                            });
                        } else {
                            commit("deletePostComment", { id, postId });
                        }
                    }
                });
        },
    },
};
