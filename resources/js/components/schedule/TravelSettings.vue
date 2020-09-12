<template>
    <div>
        <div v-if="is_travel">
            <div class="form-group row">
                <label for="distance" class="col-md-4 col-form-label text-md-right">Длина маршрута</label>

                <div class="col-md-6">
                    <input id="distance" type="number" class="form-control" name="distance" :value="old_distance" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="travel_type" class="col-md-4 col-form-label text-md-right">Тип похода</label>

                <div class="col-md-6">
                    <select v-model="old_travel_type" required class="form-control" id="travel_type" name="travel_type">
                        <option value="hiking">Пеший</option>
                        <option value="bike">Велосипедный</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input v-model="is_travel" class="form-check-input" type="checkbox" name="is_travel" id="is_travel">

                    <label class="form-check-label" for="is_travel">
                        Это поход
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'old_distance',
            'old_is_travel',
            'old_travel_type'
        ],
        data() {
            return {
                is_travel: this.old_is_travel
            }
        }
    }
</script>

<style scoped>

</style>
