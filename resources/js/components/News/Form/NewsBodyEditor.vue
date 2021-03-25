<template>
    <div>
        <editor
            :api-key="key"
            v-model="text"
            :init="{
            language: 'ru',
            menubar: false,
            elementpath: false,
            branding: false,
            plugins: 'link lists fullscreen',
            toolbar: 'h1 h2 | bold italic link | bullist numlist | fullscreen',

             content_style: '* { color: #495057 }'
        }"
        >
        </editor>

        <input name="body" id="body" type="text" v-model="text" class="d-none">
    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'

export default {
    data() {
        return {
            key: window.Laravel.tinymce_api_key,
            text: this.value
        }
    },
    props: [
        'value', 'isInvalidClass'
    ],
    components: {
        'editor': Editor
    }
}
</script>
