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
import {resizeBase64ForMaxWidth} from 'resize-base64'

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
                formats: {
                    h1: {block: 'h2'},
                    h2: {block: 'h3'},
                },

                content_style: '* { color: #212529; }',
                force_p_newlines: false,

                setup: function (editor) {
                    editor.on('OpenWindow', function (eventDetails) {
                        document.topLevelWindow = eventDetails.dialog; // document.tinymceEditor is where I keep track of my editor instance. You can probably accomplish this without using that
                    });
                },

                file_picker_types: 'image',
                file_picker_callback: function (cb, value, meta) {
                    let input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function () {
                        document.topLevelWindow.block('Загрузка файла...');

                        let file = this.files[0];

                        let reader = new FileReader();
                        reader.onload = function () {
                            resizeBase64ForMaxWidth(
                                reader.result, 1280, 720,
                                (base64) => {
                                    document.topLevelWindow.unblock()
                                    cb(base64, {title: file.name});
                                },
                                () => {
                                    document.topLevelWindow.unblock()
                                    alert('Что-то пошло не так во время загрузки изображения. Попробуйте ещё раз или обратитесь к администрации.')
                                }
                            );
                        };
                        reader.readAsDataURL(file);
                    };

                    input.click();
                },
            }
        }
    },
    props: [
        'value', 'error',
    ],
    components: {
        'editor': Editor
    }
}
</script>
