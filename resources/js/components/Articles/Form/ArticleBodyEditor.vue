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
            plugins: 'link lists',
            toolbar: 'h1 h2 | bold italic underline | link bullist',

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

<style>
.tox-tinymce {
    border-radius: 0.25rem !important;
    border: 1px solid #ced4da !important;
}

.tox-statusbar {
    border-top: none !important;
}
</style>
