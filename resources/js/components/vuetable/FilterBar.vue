<template>
    <div class="filter-bar">
        <div class="filter-bar__custom-actions">
            <slot></slot>
        </div>
        <div class="form-group">
            <label class="filter-bar__label">Search for:</label>
            <input
                type="text"
                v-model="filterText"
                class="filter-bar__input form-group__input"
                @keyup.enter="doFilter"
                placeholder="Search Keywords"
            />
            <div class="filter-bar__buttons">
                <button class="btn btn--primary" @click.prevent="doFilter">Search</button>
                <button class="btn btn--default" @click.prevent="resetFilter">Reset</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            filterText: ""
        };
    },
    methods: {
        doFilter(){
            this.$events.fire("vue-table-filter-set", this.filterText);
        },
        resetFilter(){
            this.filterText = "";
            this.$events.fire("vue-table-filter-reset");
        }
    }
};
</script>
