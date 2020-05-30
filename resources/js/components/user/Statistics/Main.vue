<template>
    <div id="statistics">
        <div class="row">
            <div class="col-lg-7 mb-2">
                <stat-rating-points :user="user"></stat-rating-points>
            </div>

            <div class="col-lg-5">
                <stat-rating-categories :user="user"></stat-rating-categories>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'user'
        ]
    }
</script>

<style scoped>

</style>
