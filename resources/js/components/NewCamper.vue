<template>
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h2>Add Campers</h2>
                <form @submit.prevent="addCamper">
                    <div class="form-group">
                        <label for="name">Camper Name</label>
                        <input v-model="name" class="form-control" name="name" type="text" id="name" :autofocus="'autofocus'">
                    </div>

                    <input class="btn btn-primary" type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: [ 'campId' ],

        data() {
            return {
                name: '',
                url: '/camps/' + this.campId + '/campers'
            }
        },

        methods: {
            addCamper() {
                axios.post(this.url, { name: this.name })
                    .catch(error => {
                        // TODO: Update flash to receive type of flash.
                        if(error.response.status === 419) {
                            // Reload will redirect to the login screen
                            location.reload();
                            flash('Not logged in');
                        } else {
                            flash(error.response.data.message);
                        }

                    })
                    .then( ({data}) => {
                        flash('New camper added!');
                        this.$emit('created', data);

                        this.resetForm();
                    });



            },

            resetForm() {
                this.name = '';
            }
        }
    }
</script>