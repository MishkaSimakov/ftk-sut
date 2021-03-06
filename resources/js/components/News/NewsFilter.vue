<template>
    <form class="form-inline row mb-5">
        <div class="input-group col-lg-10 col-12">
            <input type="text" class="form-control" placeholder="Может что-нибудь найдёте">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="btn-group col-lg-2 col-12 mt-2 mt-lg-0" role="group" aria-label="News sorting">
            <button v-on:click="setSortType('old')" type="button" :class="`btn btn-outline-secondary ${ sortType === 'old' ? 'active' : '' }`">Старые</button>
            <button v-on:click="setSortType('fresh')" type="button" :class="`btn btn-outline-secondary ${ sortType === 'fresh' ? 'active' : '' }`">Новые</button>
        </div>
    </form>
</template>

<script>
import { createNamespacedHelpers } from 'vuex'
const { mapGetters, mapActions } = createNamespacedHelpers('news');

export default {
    computed: {
        ...mapGetters({
            sortType: 'getSortType'
        })
    },
    methods: {
        ...mapActions([
            'setSortType'
        ])
    }
}
</script>
