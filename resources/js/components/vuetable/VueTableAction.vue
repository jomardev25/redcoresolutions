<template>
    <div class="custom-actions">
        <button class="btn btn--info" @click="itemAction('vue-table-view-item', rowData, rowIndex)">
            <i class="fa fa-search-plus"></i> View
        </button>
        <button class="btn btn--warning" @click="itemAction('vue-table-edit-item', rowData, rowIndex)">
            <i class="fa fa-edit"></i> Edit
        </button>
        <button class="btn btn--danger" @click="itemAction('vue-table-delete-item', rowData, rowIndex)">
            <i class="fa fa-trash"></i> Delete
        </button>
    </div>
</template>

<script>
export default {
    props: {
        rowData: {
            type: Object,
            required: true
        },
        rowIndex: {
            type: Number,
            default: 0
        }
    },
    methods: {
        itemAction(action, data, index){
            this.$events.fire(action, data);
        }
    }
};
</script>

  <style>
    .custom-actions button.ui.button {
      padding: 8px 8px;
    }
    .custom-actions button.ui.button > i.icon {
      margin: auto !important;
    }
  </style>
