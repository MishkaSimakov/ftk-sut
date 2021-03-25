<template>
    <div>
        <autocomplete
            :search="search"
            :debounce-time="500"
            :get-result-value="getResultValue"
            placeholder="Искать статьи"
        >
            <template #result="{ result, props }">
                <li v-bind="props">
                    <div class="wiki-title">
                        Hello from insight
                    </div>
                    <div class="wiki-snippet" v-html="result.snippet" />
                </li>
            </template>
        </autocomplete>
    </div>
</template>

<script>
export default {
    methods: {
        search(input) {
            return new Promise((resolve) => {
                if (input.length < 3) {
                    return resolve([])
                }

                axios.get(route('api.article.search', { query: input })).then((response) => {
                    resolve(response.data.articles)
                })
            })
        },
        getResultValue(result) {
            return result.title
        },
        // submit(value) {
        //     alert(value);
        // }
    }
}
</script>
