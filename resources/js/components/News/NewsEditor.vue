<template>
    <editor
        api-key="hnviucqus9116ko1nycfet8r4rlvw0akh6w27lord3o9nz15"
        :init="{
            language: 'ru',
            menubar: false,
            elementpath: false,
            branding: false,
            plugins: 'link lists',
            toolbar: 'h1 h2 | bold italic underline | link bullist'
        }"
        :initial-value="value"
    >
    </editor>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'

export default {
    props: [
        'value', 'is-invalid-class'
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
