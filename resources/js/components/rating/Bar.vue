<template>
    <div
        class="progress my-2"
        :style="{ cursor: 'pointer', height: '40%', width: width + '%', position: 'relative', right: align === 'left' ? width + '%' : '' }"
        :class="[ align === 'left' ? 'reversed' : '' ]"
    >
        <div
            v-for="point in user.points"

            class="progress-bar"
            :style="{ width: (user.total ? point.amount / user.total * 100 : 0) + '%', backgroundColor: point.color}"

            :data-toggle="width > 0 ? 'tooltip' : ''"
            data-placement="top"
            :title="point.title + ': ' + point.amount"
        ></div>
    </div>
</template>

<script>
    export default {
        props: [
            'user',
            'max'
        ],
        data() {
            return {
                width: this.max ? Math.abs(this.user.total) / this.max * 100 : 0,
                align: this.user.total > 0 ? 'right' : 'left'
            }
        },
        mounted() {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        },
        watch: {
            user: function() {
                this.width = this.max ? Math.abs(this.user.total) / this.max * 100 : 0
            }
        }
    }
</script>

<style scoped>
    .reversed {
        direction: rtl;
    }
</style>
