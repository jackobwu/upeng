<template>
    <div>
        <b-tabs v-model="tab">
            <b-tab-item :label="`Your Friends (${friends.length})`">
            </b-tab-item>
            <b-tab-item label="Friend requests">
            </b-tab-item>
        </b-tabs>

        <div v-if="users.length" class="columns is-multiline">
            <div v-for="user in users" :key="user.id" class="column is-half">
                <user-block :user="user">
                </user-block>
            </div>
        </div>
        <p v-else>You have no {{ ['friends', 'friend requests'][tab] }}.</p>
        
    </div>
</template>

<script>
import UserBlock from '../components/UserBlock';

export default {
    components: { UserBlock },
    data () {
        return {
            tab: 0,
            friends: [],
            requests: [],
            loading: true
        };
    },
    computed: {
        users () {
            return [this.friends, this.requests][this.tab];
        }
    },
    created () {
        this.$http.get('/api/friendships')
            .then(({ data }) => {
                this.laoding = false;
                this.friends = data.friends;
                this.requests = data.requests;
            })
            .catch((error) => {
                this.loading = false;
                console.log(error.response);
            })
    }
}
</script>

