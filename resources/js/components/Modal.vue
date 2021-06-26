<template>
    <transition name="modal">
        <div class="modal__mask">
            <div class="modal__content">
                <div class="modal__container">
                    <div :class="['modal__header', headerClass]">
                        <div class="modal__title">
                            <slot name="header"></slot>
                        </div>
                        <button
                            type="button"
                            class="modal__close"
                            @click="$emit('close')"
                        >
                        </button>
                    </div>
                    <div class="modal__body">
                        <slot></slot>
                    </div>
                    <div class="modal__footer" v-show="showFooter">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<script>
export default {
    name: "Modal",
    emits: ["close"],
    props: {
        headerClass: {
            type: String,
            default: "modal__header--primary"
        },
        showFooter: {
            type: Boolean,
            default: true
        }
    }
};
</script>
