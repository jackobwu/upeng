<template>
    <form @submit.prevent="onSubmitStatus" @keydown="clear($event.target.id)" novalidate>
        <b-field :type="(form.errors.has('body') ? 'is-danger' : '')" :message="form.errors.first('body')">
            <b-input v-model="form.body" type="textarea" id="body" :placeholder="placeholder" maxlength="300"/>
        </b-field>
        <img :src="show" >
        <b-field grouped>
            <button class="button is-primary" :class="{ 'is-loading': form.processing }" :disabled="form.errors.any()">
                {{ button }}
            </button>
            
                <div class="file is-primary">
                    <label class="file-label">
                    <input class="file-input" type="file" accept="image/*" @change="onImageChange">
                    <span class="file-cta">
                        <span class="file-label">
                            Upload
                        </span>
                    </span>
                    </label>
                </div>
            
        </b-field>
    </form>
</template>

<script>
import Form from 'form-backend-validation';

export default {

    props: {
        placeholder: {
            type: String,
            default: ''
        },
        button: {
            type: String,
            default: 'Post'
        },
        parentId: {
            type: Number,
            default: 0
        },

    },
    data () {
        return { 
            form: new Form(['body', 'image']), 
            show: null 
        };
    },
    computed: {
        endpoint () {
            return '/api/statuses' + (this.parentId > 0 ? `/${this.parentId}/replies` : '');
        },
        type () {
            return (this.parentId > 0 ? 'reply' : 'status');
        }
    },
    methods: {
        onImageChange(e){
                this.form.image = e.target.files[0];
                let image = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.show = e.target.result
                }
        },
        onSubmitStatus () {
            this.form.post(this.endpoint)
                .then(this.show = null)
                .then((response) => this.$emit(`${this.type}-posted`, response[this.type]))
                .catch((error) => console.log(error.response));
        },
        clear (id) {
            this.$nextTick(() => {
                this.form.errors.clear(id);
            });
        }
    }
};
</script>

<style scoped>
.file {
    margin-left: 5px;
}

img {
    width: 30%;
}

</style>
