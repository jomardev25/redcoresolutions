<template>
    <div class="container">
        <Header />
        <div class="wrapper">
            <Sidebar />
            <main class="main">
                <div class="heading">
                    <h1 class="heading__title">
                        {{ $route.meta.title }}
                    </h1>
                </div>
                <div class="content">
                    <transition name="fade-transform" mode="out-in">
                        <router-view />
                    </transition>
                </div>
            </main>
        </div>
    </div>
</template>
<script>
import Header from "./partials/Header";
import Sidebar from "./partials/Sidebar";
export default {
    name: "Layout",
    components: {
        Header,
        Sidebar
    }
};
</script>
