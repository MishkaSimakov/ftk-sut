<template>
    <div class="mb-2 card">
        <div class="card-header">
            Новая группа
        </div>
        <div class="card-body">
            <form action="#" @submit.prevent="send">
                <div class="form-group">
                    <input type="text" id="users" placeholder="Получатель" class="form-control">
                </div>

                <ul v-if="recipients.length" class="list-inline">
                    <li class="list-inline-item" v-for="recipient in recipients">{{ recipient.name }} [<a href="#" @click.prevent="removeRecipient(recipient)">x</a>]</li>
                </ul>

                <div class="form-group">
                    <input type="text" v-model="title" id="message" placeholder="Название беседы" class="form-control">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { userautocomplete } from '../../../helpers/autocomplete'
    import {mapActions, mapGetters} from 'vuex'

    export default {
        data() {
            return {
                title: null,
                recipients: []
            }
        },
        methods: {
            ...mapActions([
                'createChat'
            ]),
            addRecipient(recipient) {
                var existing = this.recipients.find((r) => {
                    return r.id === recipient.id
                });

                if (typeof existing !== 'undefined') {
                    return
                }

                this.recipients.push(recipient)
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
                    this.recipients = []
                    this.title = null
                })
            }
        },
        mounted() {
            var users = userautocomplete('#users').on('autocomplete:selected', (e, selection) => {
                this.addRecipient(selection)
                users.autocomplete.setVal('')
            })
        }
    }
</script>

<style lang="scss">
    .algolia-autocomplete {
        width: 100%;
    }
    .algolia-autocomplete .aa-input, .algolia-autocomplete .aa-hint {
        width: 100%;
    }
    .algolia-autocomplete .aa-hint {
        color: #999;
    }
    .algolia-autocomplete .aa-dropdown-menu {
        width: 100%;
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        float: left;
        display: none;
        padding: 4px 0;
        margin: 2px 0 0 0;
        list-style: none;
        background-color: #ffffff;
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;
    }
    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion {
        display: block;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
    }
    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion.aa-cursor {
        color: #ffffff;
        text-decoration: none;
        background-color: #0088cc;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        background-image: none;
    }
    .algolia-autocomplete .aa-dropdown-menu .aa-suggestion em {
        font-weight: bold;
        font-style: normal;
    }
</style>
