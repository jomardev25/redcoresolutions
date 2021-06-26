<template>
    <div class="w-100">
        <card>
            <template #header>
                <h6 class="card__title">User List</h6>
            </template>
            <vue-table
                api-url="/users"
                api-url-delete="/users"
                edit-route-name="users.edit"
                :fields="fields"
                :sort-order="sortOrder"
            >
                <template #custom-actions>
                    <router-link :to="{ name: 'users.create' }" class="btn btn--primary">
                        <i class="fa fa-plus"></i> Add New
                    </router-link>
                </template>
            </vue-table>
        </card>
        <modal
            v-if="showModal"
            header-class="modal__header--primary"
            @close="showModal = false"
        >
            <template #header>
                <h3>User Details</h3>
            </template>
            <form-group label="Name">
                <input
                    type="text"
                    class="form-group__input"
                    :value="user.name"
                    disabled
                />
            </form-group>
            <form-group label="Email">
                <input
                    type="text"
                    class="form-group__input"
                    :value="user.email"
                    disabled
                />
            </form-group>
            <form-group label="Role">
                <input
                    type="text"
                    class="form-group__input"
                    :value="user.role"
                    disabled
                />
            </form-group>
            <template #footer>
                <button class="btn btn--primary" @click="showModal = false">OK</button>
            </template>
        </modal>
    </div>
</template>
<script>
export default {
    name: "RoleIndex",
    data(){
        return {
            showModal: false,
            fields: [
                {
                    name: "__sequence",
                    title: "#",
                    titleClass: "text-center",
                    dataClass: "text-center",
                    width: "8%"
                },
                {
                    name: "name",
                    sortField: "name",
                    width: "20%"
                },
                {
                    name: "email",
                    sortField: "email",
                    width: "20%"
                },
                {
                    title: "Role",
                    name: "role",
                    sortField: "roles.name",
                    width: "20%"
                },
                {
                    name: "__component:vue-table-action",
                    title: "Actions",
                    titleClass: "text-center",
                    dataClass: "text-center",
                    width: "30%"
                }
            ],
            sortOrder: [
                { field: "name", sortField: "name", direction: "asc" }
            ],
            user: {
                name: "",
                description: "",
                role: ""
            }
        };
    },
    events: {
        "vue-table-view-item"(data){
            this.user.name = data.name;
            this.user.email = data.email;
            this.user.role = data.role;
            this.showModal = true;
        }
    }
};
</script>
