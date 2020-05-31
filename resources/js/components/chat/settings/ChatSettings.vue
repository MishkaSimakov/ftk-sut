<template>
    <div class="modal fade" id="chatSettingsForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Информация</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <chat-name-form v-if="chat.selfOwned"></chat-name-form>

                    <p v-else class="text-center">{{ chat.name }}</p>

                    <hr>

                    <chat-users></chat-users>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'chat'
        ]
    }
</script>

<style scoped>

</style>
