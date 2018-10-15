<template>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">
                Reply to {{ status.user.firstname }} {{ status.user.lastname }}
            </p>
        </header>
        <section class="modal-card-body">
            <status :status="status">
            </status>

            <hr>

            <status-form
                palceholder="Reply to this status"
                button="Reply"
                :parent-id="status.id"
                @reply-posted="onReplyPosted"
                >
            </status-form>
        </section>
    </div>
</template>

<script>
import Status from '../Status';
import StatusForm from '../StatusForm';

export default {
    components: { Status, StatusForm },
    props: {
        status: {
            type: Object,
            required: true
        }
    },
    methods: {
        onReplyPosted () {
            this.status.replies_count++;
            this.$parent.close();
        }
    },
    watch: {
        '$route' () {
            this.$parent.close();
        }
    }
}
</script>

<style>

</style>
