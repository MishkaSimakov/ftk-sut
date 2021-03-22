<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ article.title }}</h5>
            <div class="card-text">{{ article.truncatedBody }}</div>

            <div class="row no-gutters mt-3 text-muted">
                <span>
                    Симаков Михаил • 29 июня 2021
                </span>

                <div class="ml-auto">
                    <span class="liked" style="font-weight: 500; cursor: pointer">
                        <i class="fas fa-heart"></i> 100
                    </span>
                    <i class="fas fa-ellipsis-h ml-3" style="cursor: pointer;"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        'article': Object,
    }
}
</script>

<style scoped>
    .liked {
        color: #ff3347 !important;
    }
</style>
