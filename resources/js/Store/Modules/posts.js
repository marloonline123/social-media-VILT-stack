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
            console.log("[MUTATION] updatePosts: Post=", post);
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
            console.log("[MUTATION] deletePost: ID=", id);
        },

        deletePostComment(state, { id, postId }) {
            const post = state.posts.find((p) => p.id === postId);
            post.comments = post.comments.filter((c) => c.id !== id);
            console.log("[MUTATION] deletePostComment: ID=", id);
        },

        deletePostCommentReply(state, { id, postId }) {
            const post = state.posts.find((p) => p.id === postId);
            post.comments = post.comments.filter(
                (c) => (c.replies = c.replies.filter((r) => r.id !== id))
            );
            console.log("[MUTATION] deletePostComment: ID=", id);
        },
    },
    actions: {
        async fetchPosts({ commit }, payload = { offset: 0 }) {
            try {
                const response = await axios.get(route("posts.index", { offset: payload.offset }));

                console.log("[ACTION] fetchPosts: Posts=", response.data.posts);
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

                console.log("[ACTION] fetchPosts: Posts=", response.data.posts);
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

                console.log("[ACTION] fetchPosts: Posts=", response.data.posts);
                commit("getPosts", response.data.posts);
            } catch (error) {
                console.error("[ACTION] fetchPosts: Error fetching posts", error);
            }
        },

        async fetchGroupPosts({ commit }, { id, offset = 0 }) {
            await axios
                .get(route("groups.posts", id), {
                    params: { offset },
                })
                .then((response) => {
                    console.log(
                        "[ACTION] fetchGroupPosts: Posts=",
                        response.data.posts
                    );
                    commit("getPosts", response.data.posts);
                });
        },

        async storeComment({ commit }, { postId, body }) {
            console.log("[ACTION] storeComment: Post ID=", postId);
            await axios
                .post(route("posts.comments.store", postId), { body })
                .then((response) => {
                    console.log("the response is", response);

                    if (response.data.success) {
                        console.log(
                            "[ACTION] stored comment: Comment=",
                            response.data.data
                        );
                        commit("updatePostComment", response.data.data);
                    }
                });
        },

        async storeCommentReply({ commit }, { id, body }) {
            await axios
                .post(route("comments.reply", id), { body })
                .then((response) => {
                    console.log("the response is", response);

                    if (response.data.success) {
                        console.log(
                            "[ACTION] stored comment: Comment=",
                            response.data.data
                        );
                        commit("updatePostCommentReply", response.data.data);
                    }
                });
        },

        async updateComment({ commit }, { id, body }) {
            console.log("[ACTION] updateComment: Comment ID=", id);
            await axios
                .post(route("comments.update", id), { body, _method: "PUT" })
                .then((response) => {
                    console.log("the response is", response);
                    const comment = response.data.data;
                    if (response.data.success) {
                        console.log(
                            "[ACTION] updated comment: Comment=",
                            comment
                        );
                        if (comment.comment_id) {
                            commit("updatePostCommentReply", comment);
                        } else {
                            commit("updatePostComment", comment);
                        }
                    }
                });
        },

        async deletePost({ commit }, id) {
            console.log("[ACTION] deletePost: ID=", id);
            await axios.delete(route("posts.destroy", id)).then((response) => {
                if (response.data.status) {
                    commit("deletePost", id);
                }
            });
        },

        async deletePostComment({ commit }, { id, postId, commentId }) {
            console.log("[ACTION] deletePostComment: ID=", id);
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
