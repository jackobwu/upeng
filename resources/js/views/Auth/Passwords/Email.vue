<template>
    <div>
        <h1 class="title">Reset password</h1>

        <div class="columns">
            <div class="column is-6-widescreen is-7-desktop is-8-tablet">
                <form @submit.prevent="onSubmitSendLink" @keydown="clear($event.target.id)" novalidate>
                    <b-field label="email" label-for="email"
                        :type="(form.errors.has('email') ? 'is-danger' : '')" :message="form.errors.first('email')">
                        <b-input v-model="form.email" type="email" id="email" />
                    </b-field>

                    <b-field>
                        <button class="button is-primary" :class="{ 'is-loading': form.processing }" :disabled="form.errors.any()">
                            Send password reset link
                        </button>
                    </b-field>
                </form>
            </div>
        </div>
    </div>
    
</template>

<script>
import Form from 'form-backend-validation';

export default {
    data () {
        return { form: new Form(['email']) }
    },
    methods: {
        onSubmitSendLink () {
            this.form.post('/api/password/email')
            .catch((error) => console.log(error.response))
        },
        clear (id) {
            this.$nextTick(() => {
                this.form.errors.clear(id);
            });
        }
    }
}
</script>

<style>

</style>
