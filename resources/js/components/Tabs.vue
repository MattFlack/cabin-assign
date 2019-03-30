<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li v-for="tab in tabs" :class="[{ 'dropdown': tab.isDropdown },'nav-item']">

                    <template v-if="tab.isDropdown">
                        <a class="nav-link dropdown-toggle"
                           data-toggle="dropdown"
                           href="#" role="button"
                           aria-haspopup="true"
                           aria-expanded="false">
                            {{ tab.name }}
                        </a>

                        <div class="dropdown-menu">
                            <a v-for="dropdownItem in tab.dropdownItems"
                               class="dropdown-item"
                               :href="dropdownItem.dropdownLink">{{ dropdownItem.name }}</a>
                        </div>
                    </template>

                    <a v-else
                       :class="[{ 'active': tab.isActive }, 'nav-link']"
                       :href="tab.link"
                       @click="navigate(tab)">
                        {{ tab.name }}
                    </a>

                </li>
            </ul>
        </div>

        <div class="card-body tab-contents">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                tabs: [],
            };
        },

        created() {
            this.tabs = this.$children;
        },

        methods: {
            navigate(destinationTab) {
                if (!destinationTab.isDropdown)
                this.tabs.forEach(tab => {
                    tab.isActive = false;
                });
                destinationTab.isActive = true;
            }
        }
    }

</script>