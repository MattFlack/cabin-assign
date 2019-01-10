<template>
    <table class="table table-hover border">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col" class="text-right">Friends</th>
                <th scope="col" class="text-right"></th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="camper in this.campers">

                <!-- Camper Name -->
                <td>
                    <a :href="camperLink(camper)">
                        {{ camper.name }}
                    </a>
                </td>

                <!-- Number of Friends -->
                <td class="text-right">{{ camper.friends_count }}</td>

                <!-- Delete button -->
                <td class="text-right">
                    <form :action="camperLink(camper)" method="POST">
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
        props: ['campers'],

        data()  {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },

        methods: {
            camperLink(camper) {
                return "/camps/" + camper.camp_id + "/campers/" + camper.id;
            }
        }
    }

</script>
