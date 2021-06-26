<template>
    <header class="header">
        <router-link
            to="/"
        ><img
            src="/img/logo.png"
            alt="Logo"
            class="logo"
        /></router-link>
        <nav class="user-nav">
            <DropDown class="user-nav__user">
                <template #activator>
                    <a href="#">
                        <img
                            :src="`/${userAvatar}`"
                            alt="Avatar Photo"
                            class="user-nav__user-photo"
                        />
                        <span class="user-nav__user-name">{{ userFullName }}</span>
                    </a>
                </template>
                <DropDownItem>
                    <a href="#" @click.prevent="logout"><i class="fa fa-power-off"></i> Logout</a>
                </DropDownItem>
            </DropDown>
        </nav>
    </header>
</template>
<script>
import { mapGetters } from "vuex";
import DropDown from "@/components/DropDown";
import DropDownItem from "@/components/DropDownItem";

export default {
    name: "Header",
    components: {
        DropDown,
        DropDownItem
    },
    methods: {
        async logout(){
            await this.$store.dispatch("auth/logout");
            this.$router.push({ name: "login.index" });
        }
    },
    computed: {
        ...mapGetters(["user"]),
        userFullName(){
            return this.user !== null ? this.user.name : "";
        },
        userAvatar(){
            return this.user !== null ? this.user.avatar : "";
        }
    }
};
</script>
