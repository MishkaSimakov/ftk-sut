<template>
    <div>
        <autocomplete
            :search="search"
            placeholder="Искать статьи"
        ></autocomplete>
    </div>
</template>

<script>
export default {
    methods: {
        search(input) {
            return [
                "hello!"
            ]
        }
    }
}
</script>
