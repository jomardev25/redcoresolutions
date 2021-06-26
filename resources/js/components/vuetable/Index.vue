<template>
    <div class="vuetable-container">
        <FilterBar>
            <slot name="custom-actions"></slot>
        </FilterBar>
        <VueTable2
            ref="vuetable"
            pagination-path=""
            :api-url="apiUrl"
            :fields="fields"
            :css="css.table"
            :sort-order="sortOrder"
            :multi-sort="true"
            :append-params="moreParams"
            :http-options="httpOptions"
            @vuetable:pagination-data="onPaginationData"
        />
        <div class="vuetable-pagination">
            <VuetablePaginationInfo ref="paginationInfo" info-class="pagination-info" />
            <VuetablePagination
                ref="pagination"
                :css="css.pagination"
                @vuetable-pagination:change-page="onChangePage"
            />
        </div>
        <modal v-if="showModal" @close="showModal = false" header-class="modal__header--danger">
            <template #header>
                <h3 slot="header">Delete Item</h3>
            </template>
            <h3>Are you sure you want to delete this item?</h3>
            <template #footer>
                <button-loader ref="btnModalOk" class="btn btn--danger modal__okay-button" @click="handleDeleteItem">OK</button-loader>
                <button class="btn btn--default modal__cancel-button" @click="showModal = false">Cancel</button>
            </template>
        </modal>
    </div>
</template>

<script>
import VueTable2 from "vuetable-2/src/components/Vuetable";
import VuetablePagination from "vuetable-2/src/components/VuetablePagination";
import VuetablePaginationInfo from "vuetable-2/src/components/VuetablePaginationInfo";
import request from "@/utils/request";
import FilterBar from "./FilterBar";

export default {
    components: {
        FilterBar,
        VueTable2,
        VuetablePagination,
        VuetablePaginationInfo
    },
    props: {
        apiUrl: {
            type: String,
            required: true
        },
        fields: {
            type: Array,
            required: true
        },
        sortOrder: {
            type: Array,
            required: true
        },
        editRouteName: {
            type: String, Function,
            default: null
        },
        apiUrlDelete: {
            type: String,
            default: null
        }
    },
    data(){
        return {
            css: {
                table: {
                    tableClass: "table",
                    ascendingIcon: "fa fa-chevron-up text-primary",
                    descendingIcon: "fa fa-chevron-down text-primary"
                },
                pagination: {
                    wrapperClass: "pagination",
                    activeClass: "active",
                    disabledClass: "disabled",
                    pageClass: "page",
                    linkClass: "link",
                    icons: {
                        first: "",
                        prev: "",
                        next: "",
                        last: ""
                    }
                }
            },
            moreParams: {},
            showModal: false,
            itemId: null,
            httpOptions: {
                baseURL: request.defaults.baseURL,
                headers: request.defaults.headers.common
            }
        };
    },
    methods: {
        onPaginationData(paginationData){
            this.$refs.pagination.setPaginationData(paginationData);
            this.$refs.paginationInfo.setPaginationData(paginationData);
        },
        onChangePage(page){
            this.$refs.vuetable.changePage(page);
        },
        async handleDeleteItem(){
            this.$refs.btnModalOk.start();
            try {
                const response = request({ url: `${this.apiUrlDelete}/${this.itemId}`, method: "delete" });
                this.$nextTick(() => this.$refs.vuetable.refresh());
                this.showModal = false;
                this.$MessageBox.success(response.message);
            } catch (error) {
                if (error.response) {
                    if (error.response.status === 500) {
                        this.$MessageBox.error(error.response.data.message, "Internal Server Error");
                    }
                    if (error.response.status === 400) {
                        this.$MessageBox.error(error.response.data.message, "404 Not Found");
                    }
                }
                this.showModal = false;
                console.error(error);
            } finally {
                this.$refs.btnModalOk.stop();
            }
        }
    },
    events: {
        "vue-table-filter-set"(filterText){
            this.moreParams = {
                filter: filterText
            };
            this.$nextTick(() => this.$refs.vuetable.refresh());
        },
        "vue-table-filter-reset"(){
            this.moreParams = {};
            this.$nextTick(() => this.$refs.vuetable.refresh());
        },
        "vue-table-edit-item"(data){
            this.$router.push({ name: this.editRouteName, params: { id: data.id }});
        },
        "vue-table-delete-item"(data){
            this.itemId = data.id;
            this.showModal = true;
        }
    }
};
</script>
