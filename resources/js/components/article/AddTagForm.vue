<template>
    <div class="form-group row">
        <label for="tags" class="col-md-4 col-form-label text-md-right">Теги</label>

        <div class="col-md-7">
            <input class="rounded" id="tags" name="tags">
        </div>
    </div>
</template>

<script>
    import Tagify from '@yaireo/tagify'

    export default {
        mounted() {
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
