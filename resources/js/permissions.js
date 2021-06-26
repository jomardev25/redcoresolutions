import router from "@/router";
import store from "@/store";
import getPageTitle from "@/utils/pageTitle";
import {
    getToken
} from "@/utils/auth";

router.beforeEach(async(to, from, next) => {
    store.dispatch("app/startLoading");
    document.title = getPageTitle(to.meta.title);
    const hasToken = getToken();
    if (hasToken) {
        if (to.path === "/login") {
            next({ name: "home.index" });
        } else {
            try {
                next();
            } catch (error) {
                await store.dispatch("auth/resetToken");
                store.dispatch("app/finishLoading");
                next(`/login?redirect=${to.path}`);
            }
        }
    } else {
        const resolved = router.resolve(to.path);
        if (resolved.route.name === "pageNotFound") {
            next();
        } else {
            const whiteList = ["login.index", "pageNotFound"];
            if (whiteList.indexOf(to.name) !== -1) {
                next();
            } else {
                next(`/login?redirect=${to.path}`);
            }
        }
    }
});

router.afterEach(async() => {
    store.dispatch("app/finishLoading");
});
