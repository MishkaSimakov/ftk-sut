<template>
    <div class="container">
        <div class="container mb-2">
            <div class="row">
                <div class="col d-none d-md-block mr-1 p-0">
                    <div class="card">
                        <div class="p-1 card-body text-primary text-center" :style="{ cursor: offset ? 'pointer' : 'auto' }" v-on:click="move(-250)">
                            <i class="fa fa-angle-left my-auto"></i>
                        </div>
                    </div>
                </div>

                <div class="rounded p-0 col-12 col-md-10 col-lg-11 overflow-hidden" id="selector_container" style="white-space: nowrap">
                    <div
                        v-for="category in categories"
                        v-on:click="handleClick(category)"
                        :style="{ right: offset + 'px' }"
                        :class="['d-inline-block', { 'rating__category-selector--selected' : selected.includes(category) }, 'rating__category-selector', 'card', 'mr-2']"
                    >
                        <div class="p-1 px-2 card-body">
                            {{ category.title }}
                        </div>
                    </div>
                </div>

                <div class="col d-none d-md-block ml-1 p-0">
                    <div class="card">
                        <div class="p-1 card-body text-primary text-center" style="cursor: pointer" v-on:click="move(250)">
                            <i class="fa fa-angle-right my-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-2 card shadow w-100">
            <div class="card-body py-2">
                <div v-if="rating.length" class="col">
                    <div class="row">
                        <div :class="['col-md-1', 'font-weight-bolder', hiding]">
                            №
                        </div>
                        <div :class="['col-12', 'col-md-3', 'font-weight-bolder']">
                            Фамилия, имя
                        </div>
                        <div :class="['col-md-2', 'font-weight-bolder', hiding]">
                            Очки
                        </div>
                    </div>
                    <div v-if="rating.length" v-for="(user, place) in data" class="row">
                        <div :class="['col-1', hiding]">
                            {{ place + 1 }}
                        </div>
                        <div :class="['text-truncate', 'col-6', 'col-md-4', 'col-lg-3']">
                            <a :href="'/user/' + user.user.id">{{ user.user.name }}</a>
                        </div>
                        <div :class="['text-truncate', 'col-2', hiding]">
                            {{ user.total }}
                        </div>
                        <div :class="['col-6', 'col-md-8', 'col-lg-6']">
                            <rating-bar :max="max" :user="user"></rating-bar>
                        </div>
                    </div>
                </div>
                <div v-else class="text-primary d-flex spinner-border my-4 mx-auto" role="status">
                    <span class="sr-only">Загрузка...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'id'
        ],
        data: function () {
            return {
                hiding: {
                    'd-none': true,
                    'd-lg-block': true
                },
                rating: [],
                data: [],
                max: 0,

                categories: [],
                selected: [],

                offset: 0,
            }
        },
        methods: {
            move(offset) {
                this.offset = Math.min(
                    document.getElementById('selector_container').scrollWidth - document.getElementById('selector_container').offsetWidth,
                    Math.max(0, this.offset + offset)
                );
            },
            handleClick(category) {
                if (this.selected.includes(category)) {
                    this.selected = this.selected.filter((c) => {
                        return c.id !== category.id
                    })
                } else {
                    this.selected.push(category)
                }

                if (this.selected.length === this.categories.length || this.selected.length === 0) {
                    this.data = this.rating
                } else {
                    this.data = this.rating.map((u) => {
                        let user = JSON.parse(JSON.stringify(u));

                        user.points = user.points.filter((c) => {
                            return this.selected.find((s) => {
                                return s.id === c.id;
                            });
                        });

                        user.total = user.points.reduce((a, b) => a + b.amount, 0);

                        return user
                    });
                }

                this.prepareData(this.data);

                $(function () {
                    $('[data-toggle="tooltip"]').tooltip('dispose').tooltip();
                });
            },
            prepareData(data) {
                this.data = data.sort((a, b) => b.total - a.total);
                this.max = this.data[0].total
            }
        },
        mounted() {
            new Promise((resolve, reject) => {
                axios.get('/api/rating/' + this.id).then((response) => {
                    this.prepareData(response.data[1]);
                    this.rating = this.data;

                    this.categories = response.data[0];
                })
            });

            $(document).ready(() => {
                let move = this.move;
                let mouse_start_x = 0;
                let is_drag = false;

                $('#selector_container').on('touchstart', (e) => {
                    mouse_start_x = e.originalEvent.touches[0].pageX;
                    is_drag = true;
                });
                $(document).on('touchend', () => {
                    is_drag = false;
                }).on('touchmove', (e) => {
                    if (is_drag) {
                        move(mouse_start_x - e.originalEvent.touches[0].pageX);
                        mouse_start_x = e.originalEvent.touches[0].pageX;
                    }
                });
            })
        }
    }
</script>

<style lang="scss">
    .rating__category-selector {
        cursor: pointer;
        position: relative;

        transition: right 0.5s ease-in 0s;

        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;

        &--selected {
            color: #fff;
            background-color: #3490dc;

            &:hover {
                color: #fff !important;
                background-color: #2483d0 !important;
            }
        }

        &:hover {
            color: #16181b;
            background-color: #f8f9fa;
        }
    }
</style>
