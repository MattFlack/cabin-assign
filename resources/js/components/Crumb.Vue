<template>
    <li v-if="isCurrentPage" class="breadcrumb-item active" aria-current="page"><slot></slot></li>
    <li v-else class="breadcrumb-item"><a :href="this.link"><slot></slot></a></li>
</template>

<script>
    export default {
        props: {
                'link': { default: '' },
                'isCurrentPage': { default: false }
        },



    }
</script>