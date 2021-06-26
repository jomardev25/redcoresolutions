<template>
    <div class="home w-100">
        <h2 class="home__message">
            Welcome Back {{ userFullName }}! <br />You Logged in as {{ userRole }}
        </h2>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
    name: "Home",
    computed: {
        ...mapGetters(["user"]),
        userFullName(){
            return this.user !== null ? this.user.name : "";
        },
        userRole(){
            return this.user !== null ? this.user.role.name : "";
        }
    }
};
</script>
