<template>
    <div>
        <img data-lity style="cursor: pointer; object-fit: cover" v-bind:src="path" class="h-100 w-100 card-img" alt="Изображение пользователя">
        <a v-if="editable" style="cursor: pointer;" class="text-gray-600 upload_icon" title="Загрузить изображение" data-toggle="modal" data-target="#image-upload">
            <i class="fas fa-upload h3"></i>
        </a>

        <!-- Modal -->
        <div class="modal fade" id="image-upload" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Загрузить изображение</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div v-if="loading" class="d-flex spinner-border my-4 mx-auto" role="status">
                                <span class="sr-only">Загрузка...</span>
                            </div>

                            <div v-else class="col-md-9">
                                <img class="img-thumbnail mw-100" v-bind:src="path">

                                <button @click.prevent="change_image" class="btn btn-outline-primary mt-2 w-100">
                                    Загрузить новое фото
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'editable',
            'src'
        ],
        data() {
            return {
                loading: false,
                file: null,
                path: this.src
            }
        },
        methods: {
            change_image() {
                let input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';

                input.onchange = e => {
                    this.loading = true;

                    let file = e.target.files[0];

                    const formData = new FormData();
                    formData.append('files', file, file.name);

                    new Promise((resolve, reject) => {
                        axios.post('/settings/image', formData)
                            .then((response) => {
                                this.path = response.data;
                                this.loading = false;
                            });
                    })
                };

                input.click();
            },
        }
    }
</script>

<style scoped>
    .upload_icon {
        left: calc(100% - 1.8rem - 5px);
        top: calc(-1.8rem - 5px);
        position: relative;
    }
</style>
