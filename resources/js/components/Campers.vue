<template>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Friends</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="camper in this.campers">
                <td>
                    <a :href="'/camps/' + camper.camp_id + '/campers/' + camper.id">
                        {{ camper.name }}
                    </a>
                </td>
                <td>{{ camper.friends_count }}</td>
            </tr>
        </tbody>
    </table>

</template>

<script>

    export default {
        props: ['campers'],
    }

</script>
