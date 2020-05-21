<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-white card shadow mt-2 p-2" style="background: linear-gradient(135deg, #a8e063 0%, #56ab2f 100%);">
                    <div class="container">
                        <div class="h1 text-center">
                            {{ vote.title }}
                        </div>

                        <p class="mb-4">{{ vote.description }}</p>

                        <ul class="list-unstyled">
                            <li :class="{ 'vote__option--selected' : option.selected, 'vote__option--active' : active }" v-on:click="select(option)" v-for="option in vote.options" class="vote__option my-1 w-100 p-1 px-2 rounded">
                                {{ option.title }} <span class="float-right font-weight-bold">{{ option.percent }}%</span>
                            </li>
                        </ul>

                        <p v-if="!sending" class="text-center">Проголосовали <span class="font-weight-bold">{{ vote.users.length }}</span> человек</p>

                        <div v-else class="w-100 text-center">
                            <div class="spinner-border-sm spinner-border mx-auto" role="status">
                                <span class="sr-only">Загрузка...</span>
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
            'data',
            'active'
        ],
        methods: {
            select(option) {
                if (this.active && !option.selected) {
                    this.sending = true;

                    new Promise((resolve, reject) => {
                        axios.post('/webapi/vote/' + this.vote.id + '/vote', {
                            selected: option.id
                        }).then((response) => {
                            this.vote = response.data;

                            this.sending = false;
                        })
                    })
                }
            }
        },
        data() {
            return {
                sending: false,
                vote: JSON.parse(this.data),
            }
        }
    }
</script>

<style lang="scss">
    .vote {
        &__option {
            background-color: rgba(255, 255, 255, 0.18);

            &--active {
                cursor: pointer;
            }

            &--selected {
                background-color: rgba(255, 255, 255, 0.5);
            }

            &:hover {
                background-color: rgba(255, 255, 255, 0.3);
            }
        }
    }
</style>
