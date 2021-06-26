import { getToken, removeToken, setToken } from "@/utils/auth";
import { login, logout } from "@/api/auth";
import storage from "@/utils/storage";

const state = {
    token: getToken(),
    user: null
};

const mutations = {
    SET_TOKEN: (state, token) => {
        state.token = token;
    },
    REMOVE_TOKEN: (state) => {
        state.token = "";
    },
    SET_USER(state, user){
        state.user = user;
    }
};

const actions = {
    removeToken({ commit }){
        return new Promise((resolve) => {
            commit("REMOVE_TOKEN");
            removeToken();
            storage.remove("vuex");
            resolve();
        });
    },

    setToken({ commit }, token){
        return new Promise((resolve) => {
            commit("SET_TOKEN", token);
            setToken(token);
            resolve();
        });
    },

    setUser({ commit }, user){
        return new Promise((resolve) => {
            commit("SET_USER", user);
            resolve();
        });
    },

    login({ dispatch }, payload){
        return new Promise((resolve, reject) => {
            login(payload)
                .then((response) => {
                    this.dispatch("auth/setToken", response.token);
                    this.dispatch("auth/setUser", response.user);
                    resolve();
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    logout({ commit }){
        return new Promise((resolve, reject) => {
            logout()
                .then(() => {
                    this.dispatch("auth/removeToken");
                    commit("SET_USER", null);
                    resolve();
                })
                .catch((error) => {
                    reject(error);
                });
        });
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
