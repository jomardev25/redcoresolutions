import request from "@/utils/request";

export function login(data){
    return request({
        url: "/auth/login",
        method: "post",
        data: data
    });
}

export function logout(){
    return request({
        url: "/auth/logout",
        method: "post"
    });
}
