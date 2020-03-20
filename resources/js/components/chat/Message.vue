<template>
    <div class="m-2 ml-5">
        <div class="row">
            <strong>{{ message.user.name }}</strong>
            <span class="ml-2 text-muted">{{ message.timeForHuman }}</span>
        </div>
        <span style="white-space: pre-wrap">{{ message.body }}</span>
    </div>
</template>

<script>
    export default {
        props: [
            'message'
        ]
    }
</script>
