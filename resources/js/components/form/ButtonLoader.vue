<template>
    <button
        ref="ladda"
        :type="type"
        class="btn ladda-button"
        data-style="zoom-in"
        @click="onClick"
    >
        <span class="ladda-label">
            <slot></slot>
        </span>
    </button>
</template>
<script>
import ladda from "ladda";
export default {
    name: "ButtonLoader",
    props: {
        action: {
            type: [Function, Promise],
            default: undefined
        },
        type: {
            type: String,
            default: "button"
        }
    },
    emits: ["click"],
    data(){
        return {
            laddButton: null
        };
    },
    mounted(){
        this.laddButton = ladda.create(this.$refs.ladda);
    },
    methods: {
        async onClick(){
            if (this.action !== undefined) {
                this.laddButton.start();
                try {
                    await this.action();
                    this.laddButton.stop();
                } catch (error) {
                    this.laddButton.stop();
                }
            } else {
                this.$emit("click");
            }
        },
        start(){
            this.laddButton.start();
        },
        stop(){
            this.laddButton.stop();
        }
    }
};
</script>
