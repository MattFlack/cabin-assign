<template>
    <div>
        <transition name="slide-fade">
            <new-camper @created="add" :campId="this.campId" v-show="showNewCamper"></new-camper>
        </transition>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">

                            <div class="d-flex bd-highlight align-items-center">

                                <!--Left Header-->
                                <div class="flex-grow-1 bd-highlight">
                                    <h2 class="m-0">{{ campName }}</h2>
                                </div>

                                <!-- Right Header -->
                                <div class="bd-highlight">
                                    <button type="button" class="btn btn-link btn-sm" @click="showNewCamper = !showNewCamper">
                                        Add Camper
                                    </button>
                                    <button type="button" class="btn btn-link btn-sm" @click="showNewCamper = !showNewCamper">
                                        Add Cabin
                                    </button>
                                </div>
                            </div>

                        </div>




                        <ul class="list-group list-group-flush">
                            <li v-for="(camper, index) in this.campers" :key="camper.id" class="list-group-item d-flex bd-highlight align-items-center">

                                <!-- Left Content -->
                                <div class="flex-grow-1 bd-highlight">
                                    <a :href="campersUrl + '/' + camper.id">
                                        {{ camper.name }}
                                    </a>
                                </div>

                                <!-- Right Content -->
                                <div class="bd-highlight">
                                    <button type="button" class="btn btn-link" @click="deleteCamper(camper, index)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </li>
                        </ul>




                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import NewCamper from './NewCamper.vue';

    export default {
        components: { NewCamper },
        props: ['campId', 'campName'],

        data() {
            return {
                campers: [],
                dataSet: false,
                showNewCamper: false,
            }
        },

        computed: {
            campersUrl() {
                return '/camps/' + this.campId + '/campers'
            },
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch() {
                axios.get(this.campersUrl)
                    .then(this.refresh);
            },

            refresh({data}) {
                this.dataSet = data;
                this.campers = data.data;
            },

            deleteCamper(camper, index) {
                axios.delete(this.campersUrl + '/' + camper.id);
                this.remove(index);
                console.log("camper deleted at index " + index);
                console.log(camper);
            },

            add(camper) {
                this.campers.push(camper);
            },

            remove(index) {
                this.campers.splice(index, 1);
            }
        },

    }

</script>

<style>
    .slide-fade-enter-active,
    .slide-fade-leave-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .3s ease;
        /*position: absolute;*/
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateY(100px);
        opacity: 0;
    }
    .animated {
        /*transition: all .3s ease;*/
    }
</style>