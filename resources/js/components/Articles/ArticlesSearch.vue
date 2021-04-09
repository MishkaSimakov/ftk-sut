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
                    <ul
                        v-if="noResults"
                        class="autocomplete-result-list"
                        style="position: absolute; z-index: 1; width: 100%; top: 100%;"
                    >
                        <li class="autocomplete-result">
                            Ничего не нашлось.
                        </li>
                    </ul>
                    <ul v-bind="resultListProps" v-on="resultListListeners" class="list-group">
                        <li class="list-group-item">Статьи</li>
                        <li
                            v-for="(result, index) in results"
                            :key="resultProps[index].id"
                            class="list-group-item"
                        >
                            {{ result.name }}
                        </li>
                    </ul>
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
        }
    },

    methods: {
        search(input) {
            return new Promise((resolve) => {
                this.noResults = false

                if (input.length < 3) {
                    return resolve([])
                }

                axios.get(route('api.article.search', {query: input})).then((response) => {
                    if (!response.data[0].length) {
                        this.noResults = true
                    }

                    resolve(response.data[0])
                })
            })
        },

        // submit(value) {
        //     alert(value);
        // }
    }
}
</script>
