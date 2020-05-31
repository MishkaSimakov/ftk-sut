<template>
    <div>
        <div class="form-group row">
            <label for="type" class="col-md-4 col-form-label text-md-right">Тип</label>

            <div class="col-md-6">
                <select v-model="type" class="form-control" name="type" id="type" required>
                    <option value="monthly" selected>Рейтинг за месяц</option>
                    <option value="yearly">Рейтинг за год</option>
                </select>
            </div>
        </div>

        <div class="form-group row" id="type-month">
            <label for="date" class="col-md-4 col-form-label text-md-right">Дата</label>

            <div class="col-md-6">
                <input
                    v-if="type === 'monthly'"
                    id="date"
                    type="month"
                    :max="moment().format('Y-MM')"
                    :value="moment().format('Y-MM')"
                    :class="['form-control', { 'is-invalid': error }]"
                    name="date"

                    required
                >

                <div v-else class="input-group">
                    <input
                        v-model="year"
                        id="date"
                        name="date"
                        type="number"
                        class="form-control"
                        :max="moment().format('Y') - 1"

                        required
                    >

                    <div class="input-group-append">
                        <span class="input-group-text"> - {{ year ? parseInt(year) + 1 : 0 }} гг.</span>
                    </div>
                </div>

                <span v-if="error" class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        props: [
            'error',
            'max',
        ],
        data() {
            return {
                'year': this.moment().format('Y') - 1,
                'type': 'monthly',
            }
        },
        methods: {
            moment: moment,
        }
    }
</script>

<style scoped>

</style>
