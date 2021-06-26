import Cookies from "js-cookie";

export default {
    get(key, storage = Cookies){
        if (storage !== Cookies) {
            return storage.getItem(key) ? storage.getItem(key) : null;
        } else {
            return storage.get(key) || null;
        }
    },

    set(key, value, storage = Cookies){
        if (storage !== Cookies) {
            storage.setItem(key, value);
        } else {
            storage.set(key, value);
        }
    },

    remove(key, storage = Cookies){
        if (storage !== Cookies) {
            storage.removeItem(key);
        } else {
            storage.remove(key);
        }
    },

    removeAll(storage = Cookies){
        if (storage === localStorage) {
            localStorage.clear();
        } else if (storage === sessionStorage) {
            sessionStorage.clear();
        } else {
            Object.keys(Cookies.get()).forEach((cookie) => {
                Cookies.remove(cookie);
            });
        }
    }
};
