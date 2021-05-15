<template>
    <input id="tags" :value="this.value"
           class="rounded form-control h-auto" name="tags" :class="{ 'is-invalid': this.error.length }"
    >
</template>

<script>
import Tagify from '@yaireo/tagify'

export default {
    props: [
        'value', 'error', 'tags'
    ],
    mounted() {
        let input = document.querySelector('#tags');
        new Tagify(input, {
            whitelist: JSON.parse(this.tags).map((t) => t.name),
            maxTags: 5,
            dropdown: {
                enabled: 0,
                closeOnSelect: true
            }
        });
    }
}
</script>
