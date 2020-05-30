<template>
    <div class="form-group">
        <label for="tags">Теги</label>

        <input v-bind:value="this.value" class="rounded" id="tags" name="tags">
    </div>
</template>

<script>
    import Tagify from '@yaireo/tagify'

    export default {
        props: [
          'value'
        ],
        mounted() {
            console.log(this.value);

            new Promise((resolve, reject) => {
                axios.get('/webapi/articles/tags').then((response) => {
                    let input = document.querySelector('#tags');
                    new Tagify(input, {
                        whitelist: response.data,
                        maxTags: 10,
                        dropdown: {
                            classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
                            enabled: 0,             // <- show suggestions on focus
                            closeOnSelect: true    // <- do not hide the suggestions dropdown once an item has been selected
                        }
                    });
                })
            })

            $('form').on('submit', (e) => {

                $.each(this.tags, function(key, value) {
                    let $option = $("<option/>", {
                        value: key,
                        text: value,
                    });
                    $('select').append($option);
                });

                return true;
            })
        }
    }
</script>

<style scoped>

</style>
