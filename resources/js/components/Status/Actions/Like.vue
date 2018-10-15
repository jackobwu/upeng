<template>
    <a :class="classes" @click="onClickLike" :disabled="!canLike">
        <b-icon :icon="icon" size="is-small"></b-icon>
        <span>
            {{ status.likes_count }}
        </span>
    </a>
</template>

<script>
export default {
    props: {
        status: {
            type: Object,
            required: true
        }
    },
    computed: {
        classes () {
            return [
                'level-item',
                (this.status.liked ? 'has-text-success' : '')
            ]
        },
        icon () {
            return (this.status.liked ? 'thumb-up' : 'thumb-up-outline')
        },
        canLike () {
            return this.$_auth.check && this.status.of_friend
        }
    },
    methods: {
        onClickLike () {
            const requestType = (this.status.liked ? 'delete' : 'post');

            this.$http[requestType](`/api/statuses/${this.status.id}/likes`);
            this.$emit('like-toggled');
        }
    }

}
</script>

<style>

</style>
