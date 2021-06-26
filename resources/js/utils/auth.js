import Cookies from "js-cookie";

const TOKEN_KEY = "admin-token";

export function getToken(){
    return Cookies.get(TOKEN_KEY) || null;
}

export function setToken(token){
    return Cookies.set(TOKEN_KEY, token);
}

export function removeToken(){
    return Cookies.remove(TOKEN_KEY);
}

