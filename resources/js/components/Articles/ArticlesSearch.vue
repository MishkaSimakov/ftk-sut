<template>
    <div>
        <autocomplete
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
                        type="text"
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
                        <template
                            v-for="(title, searchType) in searchTypes"
                            v-if="resultsOfType(results, searchType).length"
                        >
                            <div
                                class="list-group-item border-top-0 border-left-0 border-right-0 font-weight-bold">
                                {{ title }}
                            </div>
                            <a
                                v-for="(result, index) in resultsOfType(results, searchType)"
                                :key="searchType + resultProps[index].id"
                                class="list-group-item list-group-item-action border-0 py-2"
                                :href="result.url"
                            >
                                {{ result.name }}
                            </a>
                        </template>

                        <a
                            class="list-group-item mt-3 card-link font-weight-bold border-0"
                            href="#"
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
            searchTypes: {
                'article': 'Статьи',
                'articletag': 'Теги',
                'user': 'Авторы',
            },
            noResults: false,
        }
    },
    methods: {
        resultsOfType(results, type) {
            return results.filter((r) => r.type === type)
        },
        search(input) {
            return new Promise((resolve) => {
                this.noResults = false

                if (input.length < 3) {
                    return resolve([])
                }

                axios.get(route('api.article.search', {query: input})).then((response) => {
                    if (!response.data.length) {
                        this.noResults = true
                    }

                    resolve(response.data)
                })
            })
        },

        // submit(value) {
        //     alert(value);
        // }
    }
}
</script>
