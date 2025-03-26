import axios from "axios";
import { router } from "@inertiajs/vue3";

const fetchFunction = axios.create({
    headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
    },
    withCredentials: true,
});

// Add a response interceptor
fetchFunction.interceptors.response.use(
    (response) => response, // Return response if successful
    (error) => {
        if (error.response) {
            const status = error.response.status;

            // if (status === 401 || status === 403) {
            //     console.error("Unauthorized! Redirecting to login...");
            //     router.visit("/login"); // Redirect to login page
            // }

            if (status === 500) {
                console.error("Server error. Please try again later.");
            }

            if (status === 422) {
                console.warn("Validation error:", error.response.data);
            }
        }

        return Promise.reject(error);
    }
);

export default fetchFunction;
