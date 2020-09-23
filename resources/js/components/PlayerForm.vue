<template>
    <form @submit.prevent="onSubmit">
        <span class="help is-danger" v-text="errors"></span>
<hr>
        <div class="row" style="padding-bottom: 20px">
            <div class="col-6">
                <div class="field">
                    <div class="control">
                        <input class="form-control" type="name" placeholder="enter player name..." v-model="name" @keydown="errors = ''">
                    </div>
                </div>
            </div>
            <div class="col-6">
                <button class="btn  btn-primary" v-bind:class="{ 'is-loading' : isLoading }">Add Player</button>
            </div>



        </div>

    </form>
</template>

<script>
    import axios from 'axios'


    export default {
        data() {
            return {
                name: '',
                errors: '',
                isLoading: false
            }
        },
        methods: {
            onSubmit() {
                this.isLoading = true
                this.postPlayer()
            },
            async postPlayer() {

        axios.post('/players', this.$data)
            .then(response => {
            this.name = ''
            this.isLoading = false
            this.$emit('completed', response.data.data)
        })
        .catch(error => {
                // handle authentication and validation errors here
                this.errors = error.response.data.errors
            this.isLoading = false
        })
    }
    }
    }
</script>
