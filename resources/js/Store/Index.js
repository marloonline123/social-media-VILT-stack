import { createStore } from "vuex";
import Upload from "./Modules/upload";
import Posts from "./Modules/Posts";

const store = createStore({
    modules: {
        Upload,
        Posts,
    },
});

export default store;
