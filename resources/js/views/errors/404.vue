<template>
    <div class="error">
        <h1 class="error_code">404</h1>
        <h5 class="mb-1">UH OH! You're lost.</h5>
        <p>
            The page you are looking for does not exist.
            How you got here is a mystery. <br />But you can click the button below to go back to the home page.
        </p>
        <router-link class="btn btn--primary" :to="{ name: 'home.index' }">
            <i class="fa fa-arrow-left"></i> Go Home
        </router-link>
    </div>
</template>
<script>
export default {
    name: "PageNotFound",
    mounted(){
        console.log(document.querySelector("body").classList);
        document.querySelector("body").classList.toggle("bg-none");
    },
    destroyed(){
        document.querySelector("body").classList.remove("bg-none");
    }
};
</script>
