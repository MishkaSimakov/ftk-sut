<template>
    <div class="input-group">
        <input aria-label="" type="text" class="form-control col-md-10" placeholder="Название чата" v-model="name">

        <div class="input-group-append">
            <a class="btn btn-outline-primary" href="#" @click.prevent="changeName">
                <span class="fa fa-check"></span>
            </a>
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
