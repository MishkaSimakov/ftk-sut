<template>
    <div>
        <editor
            :api-key="key"
            v-model="text"
            :init="settings"
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
            text: this.value,

            settings: {
                language: 'ru',
                menubar: false,
                elementpath: false,
                branding: false,
                image_upload_url: '#',
                plugins: 'link lists fullscreen hr image',
                toolbar: 'h1 h2 | link bold italic blockquote | bullist numlist hr image | fullscreen',

                content_style: '* { color: #495057 }',

                file_picker_types: 'image',
                file_picker_callback: function (cb, value, meta) {
                    let input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function () {
                        let file = this.files[0];

                        let reader = new FileReader();
                        reader.onload = function () {
                            let id = 'blobid' + (new Date()).getTime();
                            let blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                            let base64 = reader.result.split(',')[1];
                            let blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            cb(blobInfo.blobUri(), { title: file.name });
                        };
                        reader.readAsDataURL(file);
                    };

                    input.click();
                },
            }
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
