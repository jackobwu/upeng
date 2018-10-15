<template>
    <div v-infinite-scroll="fetchStatuses" infinite-scroll-disabled="disabled">

        <template v-if="$_auth.check" canPost>
            <status-form
                :placeholder="`Waht's up ${$_auth.user.firstname}?`"
                button="Post status"
                @status-posted="onStatusPosted"
            >
            </status-form>
            <hr>
        </template>

        <template v-if="statuses.length">
            <status
                v-for="status in statuses"
                :status="status"
                :key="status.id"
                :actions="['like', 'reply', 'expand', 'delete']"
                @status-deleted="onStatusDeleted"
                >
            </status>  
        </template>
        <p v-else-if="!loading">{{ empty }}</p>

        <spinner :class="{ 'is-invisible': !loading }">
        </spinner>

    </div>
</template>

<script>
import infiniteScroll from 'vue-infinite-scroll';
import StatusForm from './Status/StatusForm';
import Status from './Status/Status';
import Spinner from './Spinner';
import { removeById } from '@/util/helpers';

export default {
    components: { Status, StatusForm, Spinner },
    directives:{ infiniteScroll },
    props: {
        endpoint: {
            type: String,
            required: true
        },
        empty: {
            type: String,
            default: 'No statuses yet.'
        },
        canPost: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            statuses: [],
            cursor: null,
            loading: false,
            last: false
        }
    },
    computed: {
        disabled () {
            return this.loading || this.last;
        }
        
    },
    methods: {
        fetchStatuses () {
            this.loading = true;
            this.$http.get(this.endpoint, {
                params: { cursor: this.cursor }
            })
                .then(({ data }) => {
                    this.loading = false;
                    this.statuses = this.statuses.concat(data.records);
                    this.cursor = (data.has_next ? data.next_cursor.id : null);
                    this.last = !data.has_next;
                })
                .catch((error) => {
                    setTimeout(() => (this.loading = false), 1000);
                    console.log(error.response);
                });
        },
        onStatusPosted (status) {
            this.statuses.unshift(status);

        },
        onStatusDeleted (id) {
            removeById(this.statuses, id);
        }
    }
}
</script>

<style>

</style>
