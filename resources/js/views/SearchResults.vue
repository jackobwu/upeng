<template>
    <div>
        <h1 class="title">Your Search for "{{ keyword }}"</h1>
        <h4 class="subtitle has-text-grey">{{ users.length }} results</h4>

        <spinner v-if="loading"></spinner>
        <div v-else-if="users.length" class="columns is-multiline">
            <div v-for="user in users" :key="user.id" class="column is-half">
                <user-block :user="user"></user-block>
            </div>
        </div>
    </div>
</template>

<script>
import UserBlock from '../components/UserBlock';
import Spinner from '../components/Spinner';

export default {
    components: { UserBlock, Spinner },
    data () {
        return {
            users: [],
            keyword: '',
            loading: true
        }
    },
    methods: {
        loadResults () {
            this.loading = true;
            this.users = [];
            this.keyword = this.$route.query.keyword;
            this.$http.get('/api/search', { params: { keyword: this.keyword } })
                .then(({ data }) => {
                    this.loading = false;
                    this.users = data;
                })
                .catch((error) => {
                    this.loading = false;
                    console.log(error.response);
                })
        }
    },
    created () {
        this.loadResults();
    },
    watch: {
        '$route.query.keyword' () {
            this.loadResults();
        }
    }
}
</script>


