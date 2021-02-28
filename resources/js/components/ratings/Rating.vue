<template>
    <div class="mb-2 card w-100">
        <div class="card-body py-2">
            <div class="col">
                <div class="row">
                    <div class="col-md-1 font-weight-bolder hiding">
                        №
                    </div>
                    <div class="col-12 col-md-3 font-weight-bolder">
                        Фамилия, имя
                    </div>

                    <div class="col-md-2 font-weight-bolder hiding">
                        <div v-if="rating.length" v-for="(user, place) in data" class="row">
                            <div :class="['col-1', hiding]">
                                {{ place + 1 }}
                            </div>
                            <div :class="['text-truncate', 'col-6', 'col-md-4', 'col-lg-3']">
                                <a :href="'/user/' + user.user.id">{{ user.user.name }}</a>
                            </div>
                            <div :class="['text-truncate', 'col-2', hiding]">
                                {{ user.total }}
                            </div>
                            <div :class="['col-6', 'col-md-8', 'col-lg-6']">
                                <rating-bar :max="max" :user="user"></rating-bar>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>
