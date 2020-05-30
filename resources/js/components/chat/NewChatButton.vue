<template>
        <a title="Написать сообщение" class="h3" href="#" @click.prevent.once="click">
            <i class="fas fa-comment-alt"></i>
        </a>
</template>

<script>
    export default {
        props: [
            'recipients',
            'title'
        ],
        methods: {
            click() {
                new Promise((resolve, reject) => {
                    axios.post('/webapi/chats', {
                        title: this.title,
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
