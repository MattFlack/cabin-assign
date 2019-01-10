<template>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Sleeps</th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="cabin in this.cabins">
            <td>
                <!--<a :href="campersUrl + '/' + camper.id">-->
                {{ cabin.name }}
                <!--</a>-->
            </td>
            <td>
                {{ cabin.capacity }}
            </td>
        </tr>
        </tbody>
    </table>

</template>

<script>

    export default {
        props: ['cabins'],
    }

</script>
