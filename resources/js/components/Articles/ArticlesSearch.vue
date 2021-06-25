<template>
    <div>
        <autocomplete
            @keydown.enter="enter"
            :search="search"
            :debounce-time="500"
            placeholder="Искать статьи"
        >
            <template
                #default="{
                      rootProps,
                      inputProps,
                      inputListeners,
                      resultListProps,
                      resultListListeners,
                      results,
                      resultProps
                    }"
            >
                <div v-bind="rootProps">
                    <input
                        @keydown.enter="enter"
                        type="text"
                        v-model="query"
                        v-bind="inputProps"
                        v-on="inputListeners"
                        class="autocomplete-input form-control"
                    >

                    <div
                        class="list-group border-top autocomplete-result-list" v-if="noResults"
                        style="position: absolute; z-index: 1; width: 100%; top: 100%;"
                    >
                        <div
                            class="list-group-item border-0 font-weight-bold"
                        >
                            Ничего не нашлось.
                        </div>
                    </div>
                    <div v-bind="resultListProps" v-on="resultListListeners" class="list-group border-top">
                        <a
                            v-for="(result, index) in results"
                            :key="index"
                            class="list-group-item list-group-item-action border-0 py-2"
                            :href="result.url"
                        >
                            {{ result.title }}
                        </a>

                        <a
                            class="list-group-item mt-3 card-link font-weight-bold border-0"
                            id="all-results-link"
                            :href="route('articles.search', { query: query })"
                        >
                            Показать все результаты
                        </a>
                    </div>
                </div>
            </template>
        </autocomplete>
    </div>
</template>

<script>
export default {
    data() {
        return {
            noResults: false,

            query: '',

            minQueryLength: 3
        }
    },
    methods: {
        route: route,
        search(input) {
            return new Promise((resolve) => {
                this.noResults = false

                if (input.length < this.minQueryLength) {
                    return resolve([])
                }

                axios.get(route('articles.search', {query: input})).then((response) => {
                    if (!response.data.length) {
                        this.noResults = true
                    }

                    resolve(response.data)
                })
            })
        },
        enter() {
            if (this.query.length < this.minQueryLength || this.noResults) {
                return
            }

            document.getElementById('all-results-link').click()
        }
    }
}
</script>
