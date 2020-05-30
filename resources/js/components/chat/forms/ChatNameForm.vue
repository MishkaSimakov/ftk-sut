<template>
    <div class="input-group">
        <input aria-label="" type="text" class="form-control" placeholder="Название чата" v-model="name">

        <div class="input-group-append">
            <button class="btn btn-outline-primary" @click.prevent="changeName">
                <span class="fa fa-check"></span>
            </button>
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
