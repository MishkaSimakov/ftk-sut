<template>
    <editor
        api-key="hnviucqus9116ko1nycfet8r4rlvw0akh6w27lord3o9nz15"
        :init="{
            placeholder: 'Текст новости',
            menubar: false,
            elementpath: false,
            branding: false,
            value: '<h1>Test</h1>',
            plugins: 'codesample hr image link lists',
            toolbar: 'h1 h2 | bold italic underline | link bullist'
        }"
    >
        <h1>Hello world!</h1>
    </editor>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'

export default {
    props: [
        'text'
    ],
    components: {
        'editor': Editor
    }
}
</script>

<style scoped>

</style>
