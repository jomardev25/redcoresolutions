const state = {
    loading: 0
};

const mutations = {
    START_LOADING: (state) => {
        state.loading = state.loading + 1;
    },
    FINISH_LOADING: (state) => {
        state.loading = state.loading - 1;
    },
    RESET_LOADING: (state) => {
        state.loading = 0;
    }
};

const actions = {
    startLoading({ commit }){
        commit("START_LOADING");
    },
    finishLoading({ commit }){
        commit("FINISH_LOADING");
    },
    resetLoading({ commit }){
        commit("RESET_LOADING");
    }
};
export default {
    namespaced: true,
    state,
    mutations,
    actions
};
