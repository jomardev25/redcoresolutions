<template>
    <div class="login">
        <div class="login__wrapper">
            <div class="login__box">
                <div class="logo-main">
                    <a href="/">
                        <img src="/img/logo.png" alt="Logo" />
                    </a>
                </div>
                <form-wrapper :validator="$v.form">
                    <form @submit.prevent="handleLogin" method="POST">
                        <form-group
                            name="email"
                            attribute="email"
                            class="mb-1"
                            :server-errors="serverErrors.email"
                        >
                            <input
                                v-model="form.email"
                                type="text"
                                id="email"
                                placeholder="Email"
                                class="form-group__input"
                                @input="clearServerError('email')"
                            />
                        </form-group>
                        <form-group
                            name="password"
                            attribute="password"
                            class="mb-1"
                            :server-errors="serverErrors.password"
                        >
                            <input
                                v-model="form.password"
                                type="password"
                                id="password"
                                placeholder="Password"
                                class="form-group__input"
                                @input="clearServerError('password')"
                            />
                        </form-group>
                        <button-loader
                            type="submit"
                            ref="btnSubmit"
                            class="btn btn--primary btn--full login__button"
                            @click="handleLogin"
                        >
                            Login
                        </button-loader>
                    </form>
                </form-wrapper>
                <div class="login__copyright">
                    <p>RedCore Solutions © 2021</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { email, minValue, required } from "vuelidate/lib/validators";
export default {
    name: "Login",
    data(){
        return {
            form: {
                email: null,
                password: null
            },
            redirect: undefined,
            otherQuery: {},
            serverErrors: {}
        };
    },
    validations: {
        form: {
            email: {
                required,
                email
            },
            password: {
                required,
                minValue: minValue(8)
            }
        }
    },
    watch: {
        $route: {
            handler: function(route){
                const query = route.query;
                if (query) {
                    this.redirect = query.redirect;
                    this.otherQuery = this.getOtherQuery(query);
                }
            },
            immediate: true
        }
    },
    methods: {
        async handleLogin(){
            this.$v.form.$touch();
            if (this.$v.form.$pending || this.$v.form.$error) return;
            this.$refs.btnSubmit.start();
            try {
                await this.$store.dispatch("auth/login", this.form);
                this.$router.push({ path: this.redirect || "/", query: this.otherQuery });
            } catch (error) {
                if (error.response) {
                    if (error.response.status === 422) {
                        this.serverErrors = error.response.data.errors;
                    } if (error.response.status === 403) {
                        this.serverErrors = { email: [error.response.data.message] };
                    }
                }
            } finally {
                this.$refs.btnSubmit.stop();
            }
        },
        getOtherQuery(query){
            return Object.keys(query).reduce((acc, cur) => {
                if (cur !== "redirect") {
                    acc[cur] = query[cur];
                }
                return acc;
            }, {});
        },
        clearServerError(fieldName){
            delete this.serverErrors[fieldName];
        }
    }
};
</script>
