<template>
    <div>
        <div class="mb-4 mt-4 text-center col-md-4 offset-4">
            <button @click="assignCabins" class="btn btn-primary">Assign Cabins</button>
            <button @click="resetCabins" class="btn btn-primary">Reset</button>
        </div>

        <div v-show="unallocatedCampers.length > 0" class="card mb-4">
            <div class="card-header">Unallocated</div>
            <ul class="list-group list-group-flush">
                <li v-for="camper in unallocatedCampers"
                    :key="camper.id"
                    @click="highLightFriends(camper)"
                    class="list-group-item"
                    :class="[
                        friendsOfSelected.includes(camper.id) ? 'list-group-item-primary' : '',
                        camper.id === selectedCamper ? 'active' : ''
                    ]">
                    {{ camper.name }}

                </li>
            </ul>
        </div>

        <div class="row">
            <div v-for="cabin in cabins" class="col-sm-4">
                <div class="card mb-3">
                    <div class="card-header d-flex bd-highlight align-items-center">

                        <!-- Left Header -->
                        <div class="flex-grow-1 bd-highlight">
                            {{ cabin.name }}
                        </div>

                        <!-- Right Header -->
                        <div class="bd-highlight">
                            <template v-if="cabin.campers">
                                {{ cabin.campers.length }}/{{ cabin.number_of_beds }}
                            </template>
                        </div>

                    </div>
                    <ul class="list-group list-group-flush">
                        <li v-for="camper in cabin.campers"
                            :key="camper.id"
                            @click="highLightFriends(camper)"
                            class="list-group-item"
                            :class="[
                                camper.id === selectedCamper ? 'active' : '',
                                friendsOfSelected.includes(camper.id) ? 'list-group-item-primary' : ''
                            ]">
                            <div class="d-flex bd-highlight align-items-center">
                                <div class="flex-grow-1 bd-highlight">
                                    {{ camper.name }}
                                </div>

                                <div v-show="!hasFriendInCabin(camper, cabin.campers)" class="bd-highlight">
                                    <i title="This camper is not with any friends" class="fas fa-exclamation-circle"></i>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['campId', 'camp'],

        data() {
            return {
                unallocatedCampers: [],
                cabins: [],
                friendsOfSelected: [],
                selectedCamper: false
            }
        },

        created() {
            this.unallocatedCampers = this.camp.unallocated_campers;
            this.cabins = this.camp.cabins;
        },

        methods: {
            assignCabins() {
                axios.post('/camps/' + this.campId + '/allocate-beds')
                    .catch(error => {
                        // TODO: Update flash to receive type of flash (Error should be red).
                        flash(error.response.data.message);
                    })
                    .then( ({data}) => {
                        flash('Cabins allocated!');
                        this.cabins = data;
                        // console.log(data);
                    });
            },

            resetCabins() {
                axios.delete('/camps/' + this.camp.id + '/allocate-beds');
            },

            highLightFriends(camper) {
                this.selectedCamper = camper.id;
                this.friendsOfSelected = camper.friends.map(friend => friend.friend_id);
            },

            hasFriendInCabin(camper, cabinCampers) {
                if(camper.friends_count === 0) {
                    return true;
                }

                let cabinCamperIds = cabinCampers.map(cabinCamper => cabinCamper.id);
                let friendIdsOfCamper = camper.friends.map(friend => friend.friend_id);

                for(let i = 0; i < friendIdsOfCamper.length; i++) {
                    if(cabinCamperIds.includes(friendIdsOfCamper[i])) {
                        return true;
                    }
                }
                return false;
            }
        }
    }
</script>