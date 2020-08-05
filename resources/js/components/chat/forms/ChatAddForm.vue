<template>
    <div class="mb-2 card">
        <div class="card-body">
            <form action="#" @submit.prevent="send">
                <div class="form-group">
                    <vue-suggestion
                        placeholder="Получатель"
                        :items="items"
                        v-model="value"
                        :itemTemplate="itemTemplate"
                        @selected="addRecipient"
                        :setLabel="setLabel"
                        @changed="inputChange"
                    >
                    </vue-suggestion>
                </div>
                <ul v-if="recipients.length" class="list-inline">
                    <li class="list-inline-item" v-for="recipient in recipients">{{ recipient.name }} <a title="Удалить" class="my-auto font-weight-bolder" href="#" @click.prevent="removeRecipient(recipient)">x</a></li>
                </ul>

                <div class="form-group">
                    <input type="text" v-model="title" id="message" placeholder="Название беседы" class="form-control">
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'
    import itemTemplate from './../../UserSearchItem';

    export default {
        data() {
            return {
                title: null,
                recipients: [],
                users: [],
                items: [],
                value: '',
                itemTemplate,
            }
        },
        methods: {
            ...mapActions([
                'createChat'
            ]),
            setLabel() {
                this.value = '';
            },
            inputChange(text) {
                this.items = this.users.filter(item => (new RegExp(text.toLowerCase())).test(item.name.toLowerCase()));
            },

            addRecipient(recipient) {
                let existing = this.recipients.find((r) => {
                    return r.id === recipient.id
                });

                if (typeof existing !== 'undefined') {
                    return
                }

                this.recipients.push(recipient);
                this.value = null;
            },
            removeRecipient(recipient) {
                this.recipients = this.recipients.filter((r) => {
                    return r.id !== recipient.id
                })
            },
            send() {
                this.createChat({
                    title: this.title,
                    recipients: this.recipients.map((r) => {
                        return r.id
                    })
                }).then(() => {
                    this.recipients = [];
                    this.title = null
                })
            }
        },
        mounted() {
            new Promise((resolve, reject) => {
                axios.get('/api/users').then((response) => {
                    this.users = response.data;
                })
            });
        },
    }
</script>

<style lang="scss">
    .vue-suggestion {
        .vs__input {
            display: block;
            width: 100%;
            height: calc(1.6em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .vs__list {
            width: 100%;
            border-radius: 0.25rem;
            border: 1px solid #dee2e6;
            z-index: 100;
            background-color: #fff;
            padding: 0;

            .vs__list-item {
                display: block;
                width: 100%;
                padding: 0.25rem 1.5rem;
                clear: both;
                font-weight: 400;
                color: #212529;
                text-align: inherit;
                white-space: nowrap;
                background-color: transparent;
                border: 0;

                &:hover {
                    color: #16181b !important;
                    text-decoration: none;
                    background-color: #f8f9fa !important;
                }

                &:active {
                    color: #fff;
                    text-decoration: none;
                    background-color: #3490dc;
                }
            }
        }
    }
</style>
