<template>
    <campers :campName="this.camp.name" :campId="this.camp.id"></campers>
</template>

<script>
    import Campers from './Campers.vue';

    export default  {
        components: { Campers },

        props: ['camp'],

    }


</script>