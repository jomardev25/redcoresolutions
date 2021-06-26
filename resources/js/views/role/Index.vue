<template>
    <div class="w-100">
        <card>
            <template #header>
                <h6 class="card__title">Role List</h6>
            </template>
            <vue-table
                api-url="/roles"
                api-url-delete="/roles"
                edit-route-name="roles.edit"
                :fields="fields"
                :sort-order="sortOrder"
            >
                <template #custom-actions>
                    <router-link :to="{ name: 'roles.create' }" class="btn btn--primary">
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
                <h3>Role Details</h3>
            </template>
            <form-group label="Name">
                <input
                    type="text"
                    class="form-group__input"
                    :value="role.name"
                    disabled
                />
            </form-group>
            <form-group label="Description">
                <input
                    type="text"
                    class="form-group__input"
                    :value="role.description"
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
                    width: "10%"
                },
                {
                    name: "name",
                    sortField: "name",
                    width: "30%"
                },
                {
                    name: "description",
                    sortField: "description",
                    width: "30%"
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
            role: {
                name: "",
                description: ""
            }
        };
    },
    events: {
        "vue-table-view-item"(data){
            this.role.name = data.name;
            this.role.description = data.description;
            this.showModal = true;
        }
    }
};
</script>
