<template>
    <div v-show="isActive || isDropdown" :class="{'dropdown-menu' : isDropdown}">
        <slot></slot>
    </div>
</template>

<script>

    export default {
        props: {
            name: { required: true },
            selected: { default: false },
            isDropdown: { default: false }
        },
        data() {
            return {
                isActive: this.selected,
                dropdownItems: []
            };
        },
        computed: {
            link() {
                return '#' + this.name.toLowerCase().replace(/ /g, '-');
            }
        },

        created() {
            if (this.isDropdown) {
                this.dropdownItems = this.$children;
            }
        },
    }

</script>
