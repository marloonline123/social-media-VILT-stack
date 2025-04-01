import { createStore } from "vuex";
import Upload from "./Modules/upload";
import Posts from "./Modules/posts";
import Search from "./Modules/search";

const store = createStore({
    modules: {
        Upload,
        Posts,
        Search
    },
});

export default store;
