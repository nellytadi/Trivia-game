<template>
    <div class="columns">
        <div class="column" v-if="isLoading">Loading players...</div>
        <div class="column" v-else>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Answers</th>
                    <th>Points</th>
                    <th>Actions</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <template v-for="player in players">
                    <tr v-bind:key="player.id">
                        <td>{{ player.id }}</td>
                        <td>{{ player.name }}</td>
                        <td>{{ player.answers }}</td>
                        <td>{{ player.points }}</td>
                        <td>
                            <button class="button is-primary" v-bind:class="{ 'is-loading' : isDeleting(player.id) }" @click="deletePlayer(player.id)">Delete Player</button>
                        </td>
                        <td>
                            <button class="button is-primary" v-bind:class="{ 'is-loading' : isCountUpdating(player.id) }" @click="answer(player.id, true)">(+1) Right</button>&nbsp;
                            <button class="button is-primary" v-bind:class="{ 'is-loading' : isCountUpdating(player.id) }" @click="answer(player.id, false)">(-1) Wrong</button>&nbsp;
                            <button class="button is-primary" v-bind:class="{ 'is-loading' : isDeleting(player.id) }" @click="deletePlayer(player.id)">Delete Player</button>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
            <player-form @completed="addPlayer"></player-form>
        </div>

        <div class="column">
            <div class="card" v-if="question">
                <div class="card-content">
                    <button class="button is-primary" @click="getQuestion()">Refresh Question</button>
                    <p class="title">

                    </p>
                    <p class="subtitle">

                    </p>
                </div>
                <footer class="card-footer">
                    <p class="card-footer-item">
                        <span>Correct answer: </span>
                    </p>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import PlayerForm from './PlayerForm.vue'
    import Vue from 'vue'

    export default {
        components: {
            PlayerForm
        },
        data() {
            return {
                isLoading: true,
                question: null,
                players: {}
            }
        },
        async created () {
        this.getQuestion()

        try {
            const response = await axios.get('/players')
            this.players = response.data.data
            this.isLoading = false
        } catch (e) {
            // handle the authentication error here
        }
    },
    methods: {
        async getQuestion() {

            this.doGetQuestion()

        },
        async doGetQuestion() {
            try {
                const response = await axios.get('/trivia')
                console.log(response.data.question)
                this.question = response.data.question

            } catch (e) {
                console.error(e);
            }
        },
        addPlayer(player) {
            this.players.push(player)
        },
        isDeleting(id) {
            let index = this.players.findIndex(player => player.id === id)
            return this.players[index].isDeleting
        },
        async deletePlayer(id) {
            let index = this.players.findIndex(player => player.id === id)
            Vue.set(this.players[index], 'isDeleting', true)
            await axios.delete('/players/' + id)
            this.players.splice(index, 1)
        },
        isCountUpdating(id) {
            let index = this.players.findIndex(player => player.id === id)
            return this.players[index].isCountUpdating
        },
        async answer(id, isCorrectAnswer) {
            let data = {
                correct: isCorrectAnswer
            }
            let index = this.players.findIndex(player => player.id === id)
            Vue.set(this.players[index], 'isCountUpdating', true)
            const response = await axios.post('/players/' + id + '/answers', data)
            this.players[index].answers = response.data.data.answers
            this.players[index].points = response.data.data.points
            this.players[index].isCountUpdating = false
        }

    }
    }
</script>