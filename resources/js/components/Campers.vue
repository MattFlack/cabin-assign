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
                                    <button type="button" class="btn btn-secondary btn-sm" @click="showNewCamper = !showNewCamper">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="panel-body">
                            <article>

                                <ul class="list-group">
                                    <li v-for="camper in this.campers" class="list-group-item">
                                        <a :href="campersUrl + '/' + camper.id">
                                            {{ camper.name }}
                                        </a>
                                    </li>
                                </ul>

                            </article>
                        </div>

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

            add(camper) {
                this.campers.push(camper);
            },
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