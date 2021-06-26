import request from "@/utils/request";

export function fetchRole(id){
    return request({
        url: `/roles/${id}`,
        method: "get"
    });
}

export function fetchEditRole(id){
    return request({
        url: `/roles/${id}/edit`,
        method: "get"
    });
}

export function createRole(payload){
    return request({
        url: "/roles",
        method: "post",
        data: payload
    });
}

export function updateRole(id, payload){
    return request({
        url: `/roles/${id}`,
        method: "patch",
        data: payload
    });
}
