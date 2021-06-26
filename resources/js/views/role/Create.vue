<template>
    <div class="w-100">
        <card>
            <template #header>
                <h6 class="card__title">Create Role</h6>
            </template>
            <form-wrapper :validator="$v.form">
                <form @submit.prevent="handleCreateRole">
                    <form-group
                        label="Role"
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
                        />
                    </form-group>
                    <form-group
                        label="Description"
                        name="description"
                        attribute="description"
                        :server-errors="serverErrors.description"
                        :required="true"
                    >
                        <input
                            v-model="form.description"
                            type="text"
                            id="description"
                            class="form-group__input"
                            :disabled="loading"
                        />
                    </form-group>
                </form>
            </form-wrapper>
            <template #footer>
                <div class="form-action">
                    <span>
                        <router-link :to="{ name: 'roles.index' }" class="btn-inline">
                            <span><i class="fa fa-reply"></i></span> Back
                        </router-link>
                    </span>
                    <button-loader ref="btnSubmit" class="btn--primary" @click="handleCreateRole">Create Role</button-loader>
                </div>
            </template>
        </card>
    </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";
import { createRole } from "@/api/role";
export default {
    name: "Create",
    data(){
        return {
            loading: false,
            form: {
                name: "",
                description: ""
            },
            serverErrors: {}
        };
    },
    validations: {
        form: {
            name: {
                required
            },
            description: {
                required
            }
        }
    },
    methods: {
        async handleCreateRole(){
            this.$v.form.$touch();
            if (this.$v.form.$pending || this.$v.form.$error) return;
            this.$refs.btnSubmit.start();
            this.loading = true;
            try {
                const response = await createRole(this.form);
                this.$router.push({ name: "roles.index" });
                this.$MessageBox.success(response.message);
            } catch (error) {
                if (error.response) {
                    if (error.response.status === 422) { this.serverErrors = error.response.data.errors; }
                }
            } finally {
                this.loading = false;
                this.$refs.btnSubmit.stop();
            }
        }
    }
};
</script>
