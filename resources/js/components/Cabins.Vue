<template>
    <table class="table table-hover border">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th class="text-right" scope="col">Sleeps</th>
            <th class="text-right" scope="col"></th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="cabin in this.cabins">

            <!-- Cabin Name -->
            <td>
                {{ cabin.name }}
            </td>

            <!-- Number of beds -->
            <td class="text-right">
                {{ cabin.capacity }}
            </td>

            <!-- Delete Button -->
            <td class="text-right">

                <form :action="cabinLink(cabin)" method="POST">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" class="btn btn-link btn-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        </tbody>
    </table>

</template>

<script>

    export default {
        props: ['cabins'],

        data()  {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },

        methods: {
            cabinLink(cabin) {
                return "/camps/" + cabin.camp_id + "/cabins/" + cabin.id;
            }
        }
    }

</script>
