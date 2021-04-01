<template>
    <div ref="news_date_editor_container">
        <div class="form-check">
            <input id="delayed_publication" type="checkbox"
                   class="form-check-input" name="delayed_publication"
                   v-model="is_delayed_publication"
                   autofocus
            >
            <label for="delayed_publication" class="form-check-label">Отложенная публикация</label>
        </div>

        <div class="form-group" v-if="is_delayed_publication">
            <input id="date" type="date"
                   class="form-control" name="date"
                   :value="$moment().format('YYYY-MM-DD')"
                   :min="$moment().format('YYYY-MM-DD')" required autofocus
            >
        </div>
    </div>
</template>

<script>
import smoothHeight from "vue-smooth-height";

export default {
    mixins: [smoothHeight],
    data() {
        return {
            is_delayed_publication: '',
        }
    },
    mounted() {
        this.$smoothElement({
            el: this.$refs.news_date_editor_container,
            hideOverflow: true,
        })
    }
}
</script>

<style scoped>

</style>
