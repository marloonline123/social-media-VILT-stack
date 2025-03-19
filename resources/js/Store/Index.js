import { createStore } from "vuex";
import Upload from "./Modules/upload";

const store = createStore({
    modules: {
        Upload, // Register upload module
    },
});

export default store;
