<template>
    <button
        @click.prevent="click"
        class="btn btn-outline-primary w-100">
        Написать сообщение
    </button>
</template>

<script>
    export default {
        props: [
            'recipients'
        ],
        methods: {
            click() {
                new Promise((resolve, reject) => {
                    axios.post('/webapi/chats', {
                        title: "Chat",
                        recipients: [JSON.parse(this.recipients).id]
                    }).then((response) => {
                        window.history.pushState(null, null, response.data);
                        location.reload();
                    })
                })
            }
        }
    }
</script>
