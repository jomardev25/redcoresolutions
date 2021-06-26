<template>
    <div class="w-100">
        <card>
            <template #header>
                <h6 class="card__title">Create User</h6>
            </template>
            <form-wrapper :validator="$v.form">
                <form @submit.prevent="handleCreateUser">
                    <form-group
                        label="Name"
                        name="name"
                        attribute="name"
                        :server-errors="serverErrors.name"
                        :required="true"
                    >
                        <input
                            v-model="form.name"
                            type="text"
                            id="name"
                            class="form-group__input"
                            :disabled="loading"
                            @input="clearServerError('name')"
                        />
                    </form-group>
                    <form-group
                        label="Email"
                        name="email"
                        attribute="email"
                        :server-errors="serverErrors.email"
                        :required="true"
                    >
                        <input
                            v-model="form.email"
                            type="text"
                            id="email"
                            class="form-group__input"
                            :disabled="loading"
                            @input="clearServerError('email')"
                        />
                    </form-group>
                    <form-group
                        label="Role"
                        name="role_id"
                        attribute="role"
                        :server-errors="serverErrors.role_id"
                        :required="true"
                    >
                        <multiselect
                            v-model="selectedRole"
                            deselect-label="Can't remove this value"
                            track-by="name"
                            label="name"
                            placeholder="Select an option"
                            :options="roles"
                            :searchable="true"
                            :allow-empty="false"
                            :show-labels="false"
                            @input="handleChangeRole"
                        >
                            <template slot="singleLabel" slot-scope="{ option }">
                                <strong>{{ option.name }}</strong>
                            </template>
                        </multiselect>
                    </form-group>
                    <form-group
                        label="Password"
                        name="password"
                        attribute="password"
                        :server-errors="serverErrors.password"
                        :required="true"
                    >
                        <input
                            v-model="form.password"
                            type="password"
                            id="password"
                            class="form-group__input"
                            :disabled="loading"
                            @input="clearServerError('password')"
                        />
                    </form-group>
                    <form-group
                        label="Confirm Password"
                        name="password_confirmation"
                        attribute="password confirmation"
                        :server-errors="serverErrors.password_confirmation"
                        :required="true"
                    >
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            id="password_confirmation"
                            class="form-group__input"
                            :disabled="loading"
                            @input="clearServerError('password_confirmation')"
                        />
                    </form-group>
                </form>
            </form-wrapper>
            <template #footer>
                <div class="form-action">
                    <span>
                        <router-link :to="{ name: 'users.index' }" class="btn-inline">
                            <span><i class="fa fa-reply"></i></span> Back
                        </router-link>
                    </span>
                    <button-loader ref="btnSubmit" class="btn--primary" @click="handleCreateUser">Create User</button-loader>
                </div>
            </template>
        </card>
    </div>
</template>
<script>
import { email, minValue, required, sameAs } from "vuelidate/lib/validators";
import { createUser, fetchCreateUser } from "@/api/user";
export default {
    name: "Create",
    data(){
        return {
            loading: false,
            form: {
                name: null,
                email: null,
                role_id: null,
                password: null,
                password_confirmation: null
            },
            selectedRole: null,
            roles: [],
            serverErrors: {}
        };
    },
    validations: {
        form: {
            name: {
                required
            },
            email: {
                required,
                email
            },
            role_id: {
                required
            },
            password: {
                required,
                minValue: minValue(8)
            },
            password_confirmation: {
                required,
                minValue: minValue(8),
                sameAsPassword: sameAs("password")
            }
        }
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        async fetchData(){
            try {
                const response = await fetchCreateUser();
                this.roles = response.data.roles;
            } catch (error) {
                console.error(error);
            }
        },
        async handleCreateUser(){
            this.$v.form.$touch();
            if (this.$v.form.$pending || this.$v.form.$error) return;
            this.$refs.btnSubmit.start();
            this.loading = true;
            try {
                const response = await createUser(this.form);
                this.$router.push({ name: "users.index" });
                this.$MessageBox.success(response.message);
            } catch (error) {
                if (error.response) {
                    if (error.response.status === 422) { this.serverErrors = error.response.data.errors; }
                }
            } finally {
                this.loading = false;
                this.$refs.btnSubmit.stop();
            }
        },
        handleChangeRole(value, id){
            this.form.role_id = value.id;
        },
        clearServerError(fieldName){
            delete this.serverErrors[fieldName];
        }
    }
};
</script>
