import request from "@/utils/request";

export function fetchCreateUser(){
    return request({
        url: `/users/create`,
        method: "get"
    });
}

export function fetchUser(id){
    return request({
        url: `/users/${id}`,
        method: "get"
    });
}

export function fetchEditUser(id){
    return request({
        url: `/users/${id}/edit`,
        method: "get"
    });
}

export function createUser(payload){
    return request({
        url: "/users",
        method: "post",
        data: payload
    });
}

export function updateUser(id, payload){
    return request({
        url: `/users/${id}`,
        method: "patch",
        data: payload
    });
}

