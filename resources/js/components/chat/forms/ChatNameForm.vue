<template>
    <div class="card mb-2">
        <div class="card-header">
            Название
        </div>
        <div class="card-body">
            <div class="row container">
                <input type="text" class="form-control col-md-10" placeholder="Название чата" v-model="name">
                <a class="mx-auto my-auto" href="#" @click:prevent="changeName">
                    <span class="fa fa-save fa-2x"></span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        data() {
            return {
                name: null,
            }
        },
        computed: mapGetters({
            chat: 'currentChat'
        }),
        methods: {
            ...mapActions([
                'changeChatName'
            ]),
            changeName() {
                this.changeChatName({
                    id: this.chat.id,
                    name: this.name
                })
            }
        },
        mounted() {
            this.name = this.chat.name
        }
    }
</script>

<style scoped>

</style>
