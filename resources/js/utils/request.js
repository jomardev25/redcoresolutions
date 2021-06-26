import axios from "axios";
import store from "@/store";
import MessageBox from "@/components/messagebox";
import {
    getToken
} from "@/utils/auth";

const service = axios.create({
    baseURL: "/api/v1",
    timeout: 90000
});

const token = document.head.querySelector('meta[name="csrf-token"]');

if (!token) {
    console.error("CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token");
}

const AUTH_TOKEN = getToken();

service.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": token.content,
    "Authorization": `Bearer ${AUTH_TOKEN}`
};

service.interceptors.request.use(
    (config) => {
        store.dispatch("app/startLoading");
        return config;
    },
    (error) => {
        console.error(error);
        store.dispatch("app/finishLoading");
        return Promise.reject(error);
    }
);

service.interceptors.response.use(
    (response) => {
        const res = response.data;
        if (response.headers["content-type"] !== "application/json") {
            store.dispatch("app/finishLoading");
            return response;
        } else if (res.status !== 200) {
            MessageBox.error(res.message);
            store.dispatch("app/finishLoading");
            return Promise.reject(new Error(res.message || "Error"));
        } else {
            store.dispatch("app/finishLoading");
            return res;
        }
    },
    (error) => {
        if (error.response) {
            const response = error.response.data;
            if (error.response.status === 422 && response.message === "The given data was invalid.") {
                MessageBox.error("Please fill in all the required fields.", "Invalid Input");
            } else if (error.response.status === 500) {
                MessageBox.error(response.message, "500 Server Error");
            } else if (error.response.status === 404) {
                MessageBox.error(response.message, "404 Not Found");
            } else if (error.response.status === 401) {
                MessageBox.error(response.message, "401 Unauthorized");
            } else if (response.message !== "The given data was invalid.") {
                if (error.response.status !== 422 || error.response.status !== 403) {
                    MessageBox.error(response.message, error.response.statusText);
                }
            }
        } else if (error.request) {
            console.error(error.request);
        } else {
            console.error("Error", error.message);
        }
        store.dispatch("app/finishLoading");
        return Promise.reject(error);
    }
);

export default service;
