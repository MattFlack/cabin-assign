<template>
    <form :action="endPoint" method="POST">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="camper_id" :value="camper.id">

        <div class="form-group">
            <select name="friend_id" class="custom-select custom-select-lg" id="campers" @change="checkValid()" v-model="selected">
                <option :value="false" selected>Select a friend</option>

                <option
                    v-for="potentialFriend in campers"
                    :value="potentialFriend.id"
                    :disabled="isFriend(potentialFriend.id)"
                    v-if="potentialFriend.id !== camper.id">
                        {{ potentialFriend.name }}
                </option>

            </select>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="!isValid">Submit</button>
    </form>
</template>

<script>
    export default {
        props: [ 'friends', 'endPoint', 'campers', 'camper' ],

        data()  {
            return {
                isValid: false,
                selected: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },

        computed: {
            friendIds() {
                return this.friends.map((friend) => {
                    return friend.friend_id;
                })
            }
        },

        methods: {

            checkValid() {
                console.log("Selecting: " + this.selected);
                if (this.isPlaceholder() || this.isFriend(this.selected)) {
                    this.isValid = false;
                } else {
                    this.isValid = true;
                }
            },

            isPlaceholder() {
                // Value of the placeholder is false
                return !this.selected;
            },

            isFriend(camperId) {
                console.log(this.friendIds.includes(camperId));
                return this.friendIds.includes(camperId);
            },
        }
    }
</script>