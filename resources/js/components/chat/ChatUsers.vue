<template>
    <div class="card">
        <div class="card-header">
            Участники чата
        </div>
        <div class="card-body">
            <chat-user-add-form v-if="chat.selfOwned"></chat-user-add-form>
            <ul>
                <li v-for="user in chat.users">{{ user.name }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'chat'
        ],
    }
</script>
