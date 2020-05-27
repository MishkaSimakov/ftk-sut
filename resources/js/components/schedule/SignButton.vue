<template>
    <div class="mt-auto">
        <div v-if="loading">
            <div class="btn btn-outline-secondary">
                <div class="spinner-border-sm spinner-border mx-1 my-auto" role="status">
                    <span class="sr-only">Загрузка...</span>
                </div>
            </div>
        </div>

        <div v-else>
            <div v-if="schedule.isRegister" class="btn-group">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Вы пойдёте
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" v-on:click.prevent="openPeopleList()">Кто пойдёт</a>
                    <a class="dropdown-item" href="#" v-on:click.prevent="set_register(0)">Не пойду</a>
                </div>
            </div>


            <div v-else class="btn-group">
                <button v-on:click="set_register(true)" type="button" class="btn btn-outline-primary">Пойду</button>
                <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" v-on:click.prevent="openPeopleList()">Кто пойдёт</a>
                </div>
            </div>
        </div>

        <people-list ref="peoples" v-bind:schedule="schedule"></people-list>
    </div>
</template>

<script>
    export default {
        props: [
            'data',
            'url',
        ],
        data() {
            return {
                schedule: JSON.parse(this.data),
                loading: false
            }
        },
        methods: {
            set_register(state) {
                this.loading = true;

                new Promise((resolve, reject) => {
                    axios.post(this.url, {
                        state: state
                    }).then((response) => {
                        this.schedule = response.data;
                        this.loading = false;
                    })
                });
            },
            openPeopleList() {
                $(this.$refs.peoples.$el).modal('show')
            }
        }
    }
</script>

<style scoped>

</style>
