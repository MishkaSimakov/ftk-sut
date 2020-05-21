<template>
    <div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Вопросы</label>

            <div class="col-md-6">
                <div id="question_container">
                    <div data-id="0" class="col p-0 question__input">
                        <input class="form-control" type="text" name="question[0]">

                        <a onclick="$('*[data-id=0]').remove();" href="#" class="text-muted question__remove">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>

                    <div data-id="1" class="col p-0 question__input">
                        <input class="form-control" type="text" name="question[1]">

                        <a onclick="$('*[data-id=1]').remove();" href="#" class="text-muted question__remove">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <div v-on:click="addQuestion" style="cursor: text;" class="mt-2 text-muted form-control">
                    Добавить вопрос...
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                count: 2,
            }
        },
        methods: {
            addQuestion() {
                $('#question_container').append('<div data-id="' + this.count + '" class="col p-0 question__input"><input class="form-control" type="text" name="question[' + this.count + ']"><a onclick="$(\'*[data-id=' + this.count + ']\').remove();" href="#" class="text-muted question__remove"><i class="fa fa-times"></i></a></div>');
                $('#question_container input:last-child').focus();

                this.count += 1
            }
        }
    }
</script>

<style lang="scss">
    #question_container {
        .question__input {
            margin-top: 0.5rem;

            &:first-child {
                margin-top: 0;
            }
        }
    }

    .question {
        &__remove {
            position: absolute;
            top: .5rem;
            right: 1rem;
            z-index: 2;
            opacity: 0;
            display: block;
            text-align: center;
            transition: opacity 100ms ease-in 250ms;
        }

        &__input:hover {
            .question__remove {
                opacity: 1 !important;
            }
        }
    }
</style>
