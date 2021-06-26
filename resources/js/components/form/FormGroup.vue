<template>
    <div class="form-group" :class="{ 'form-group--invalid': hasAnyErrors }">
        <label class="form-group__label">
            {{ label }} <template v-if="required"><span class="required">*</span></template>
        </label>
        <slot></slot>
        <template v-if="hasAnyErrors">
            <span v-for="error in activeErrorMessages" :key="error" class="form-group__error">
                {{ error }}
            </span>
            <span v-for="error in serverErrors" :key="error" class="form-group__error">{{ error }}</span>
        </template>
    </div>
</template>
<script>
import { singleErrorExtractorMixin } from "vuelidate-error-extractor";

export default {
    mixins: [singleErrorExtractorMixin],
    props: {
        required: {
            type: Boolean,
            default: false
        },
        serverErrors: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        hasAnyErrors(){
            return this.hasErrors || this.serverErrors.length;
        }
    }
};
</script>
