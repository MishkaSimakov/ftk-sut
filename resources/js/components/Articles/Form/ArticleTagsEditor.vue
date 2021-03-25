<template>
    <input id="tags" :value="this.value"
           class="rounded" name="tags"
    >
</template>

<script>
import Tagify from '@yaireo/tagify'
import {createNamespacedHelpers} from 'vuex'

const {mapGetters, mapActions} = createNamespacedHelpers('articles');

export default {
    props: [
        'value',
    ],
    data() {
        return {
            tagify: null,
        }
    },
    computed: {
        ...mapGetters({
            tags: 'getTags'
        })
    },
    methods: {
        ...mapActions([
            'loadTags'
        ])
    },
    mounted() {
        this.loadTags();

        let input = document.querySelector('#tags');
        this.tagify = new Tagify(input, {
            whitelist: [],
            maxTags: 5,
            dropdown: {
                enabled: 0,
                closeOnSelect: true
            }
        });
    },
    watch: {
        tags(tags) {
            this.tagify.settings.whitelist = tags.map((t) => t.name);
        }
    }
}
</script>

<style scoped>

</style>
