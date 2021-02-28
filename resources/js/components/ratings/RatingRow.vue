<template>
    <li class="list-group-item border-0 py-1">
        <a class="row text-decoration-none text-reset" data-toggle="collapse" :href="`#rating-statistics-${id}`" role="button" aria-expanded="false"
           :aria-controls="`rating-statistics-${id}`">
            <div class="col-md-1">1</div>
            <div class="col-md-2">Симаков Михаил</div>
            <div class="col-md-3">1010 <i class="text-success fas fa-angle-up"></i></div>
            <div class="col-md-6">очки</div>
        </a>

        <div :id="`rating-statistics-${id}`" class="collapse" aria-labelledby="headingOne" data-parent="#rating-card">

        </div>
    </li>
</template>

<script>
export default {
    data() {
        return {
            'id': this._uid,
        }
    }
}
</script>
