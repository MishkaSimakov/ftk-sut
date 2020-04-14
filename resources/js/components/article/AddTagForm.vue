<template>
    <div class="form-group row">
        <label for="photos" class="col-md-4 col-form-label text-md-right">Теги</label>

        <div class="col-md-7">
            <div class="input-group">
                <input list="tags" v-on:keydown.enter.prevent="addTag" type="text" v-model="tag" id="tag" class="form-control">

                <datalist id="tags">
                    <option v-for="tag in decodeURI(existing_tags)" v-bind:value="tag"></option>
                </datalist>

                <div class="input-group-append">
                    <a class="btn btn-outline-primary" href="#" @click.prevent="addTag">
                        <span class="fa fa-plus"></span>
                    </a>
                </div>
            </div>

            <ul class="list-inline mt-2">
                <li class="list-inline-item" v-for="tag in tags">{{ tag }} [<a href="#" @click.prevent="deleteTag(tag)">x</a>]</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
          'existing_tags'
        ],
        data() {
            return {
                tag: null,
                tags: []
            }
        },
        methods: {
            addTag() {
                if (!this.tag || this.tag.trim() === '') {
                    return
                }

                this.tags.push(this.tag)
                this.tag = null;
            },
            deleteTag(tag) {
                this.tags = this.tags.filter((t) => {
                    return t !== tag
                })
            }
        },
        mounted() {
            console.log(this.existing_tags)
        }
    }
</script>

<style scoped>

</style>
