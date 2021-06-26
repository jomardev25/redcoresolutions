<template>
    <div class="dropdown" v-click-outside="closeDropdown">
        <div class="dropdown__activator" @click="showDropdown">
            <slot name="activator"></slot>
        </div>
        <transition name="slide">
            <ul class="dropdown__list" v-show="toggle">
                <slot></slot>
            </ul>
        </transition>
    </div>
</template>
<script>
export default {
    name: "DropDown",
    data(){
        return {
            toggle: false
        };
    },
    methods: {
        closeDropdown(){
            this.toggle = false;
        },
        showDropdown(){
            const self = this;
            if (this.toggle === false) {
                this.$parent.$children.filter((value) => {
                    if (value !== self) {
                        if (value.toggle === true) {
                            value.toggle = false;
                        }
                    }
                });
            }
            this.toggle = !this.toggle;
        }
    }
};
</script>
