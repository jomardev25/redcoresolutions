const getters = {
    loading: state => state.app.loading,
    token: state => state.auth.token,
    user: state => state.auth.user
};
export default getters;
