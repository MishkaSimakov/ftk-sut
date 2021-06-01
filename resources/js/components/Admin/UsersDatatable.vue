<template>
    <div class="card">
        <div class="card-body p-0">
            <div class="form-inline m-3">
                <div class="form-group mb-0">
                    <label for="perpage" class="d-none d-sm-inline">На странице:</label>
                    <select id="perpage" class="form-control custom-select custom-select-sm w-auto ml-2"
                            v-model="paginationData.perPage" @input="setPage(1)">
                        <option
                            v-for="option in perPageOptions"
                            :key="option"
                            :value="option"
                        >
                            {{ option }}
                        </option>
                    </select>
                </div>

                <div class="form-group mb-0 ml-auto">
                    <label for="search" class="d-none d-sm-inline">Поиск:</label>
                    <input id="search" class="form-control form-control-sm w-auto ml-2" type="text" v-model="query"
                           @input="setPage(1)">
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered border-top border-bottom mb-0" style="border-style: hidden;">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Регистрационный код</th>
                        <th>Зарегистрирован</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in filteredAndPaginatedUsers" :key="user.id">
                        <td>
                            <a :href="user.url" title="Страница пользователя" class="text-nowrap">{{ user.name }}</a>
                        </td>
                        <td>{{ user.register_code }}</td>
                        <td>{{ user.email ? 'Да' : 'Нет' }}</td>
                        <td class="text-center">
                            <a
                                :href="route('users.edit', {'user': user.id})"
                            >
                                Редактировать
                            </a>


                            <a
                                class="text-danger ml-3"
                                href="#"
                                v-on:click.prevent="deleteUser(user)"
                            >
                                Удалить
                            </a>

                            <form :id="`delete-user-form-${user.id}`"
                                  :action="route('users.destroy', {'user': user.id})" method="POST" class="d-none">
                                <input type="hidden" name="_token" :value="csrf">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <nav>
                <ul class="pagination justify-content-end m-3">
                    <li class="page-item" :class="paginationData.page <= 1 ? 'disabled' : ''">
                        <button class="page-link" aria-label="Previous" v-on:click="setPage(paginationData.page - 1)">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </button>
                    </li>

                    <li
                        v-for="p in paginationData.pages"
                        class="page-item"
                        :class="{'active': p === paginationData.page, 'disabled': p === '...'}"
                    >
                        <button class="page-link" v-on:click="setPage(p)">
                            {{ p }}
                        </button>
                    </li>

                    <li class="page-item" :class="paginationData.page >= paginationData.totalPages ? 'disabled' : ''">
                        <button class="page-link" aria-label="Next" v-on:click="setPage(paginationData.page + 1)">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        users: String,
    },
    data() {
        return {
            csrf: window.Laravel.csrfToken,

            query: '',
            perPageOptions: [10, 50, 100],

            paginationData: {
                page: 1,
                totalPages: 0,
                perPage: 10,

                pages: []
            }
        }
    },
    computed: {
        parsedUsers() {
            return JSON.parse(this.users)
        },
        filteredAndPaginatedUsers() {
            let users = this.getFilteredUsers(this.parsedUsers);

            this.recountPages(users)

            users = this.getPaginatedUsers(users);

            return users
        }
    },
    methods: {
        route: route,
        getFilteredUsers(users) {
            if (this.query) {
                return users.filter((u) => {
                    return u.name.toLowerCase().includes(this.query.toLowerCase());
                });
            }

            return users;
        },
        getPaginatedUsers(users) {
            let startIndex = (this.paginationData.page - 1) * this.paginationData.perPage;
            let endIndex = Math.min(startIndex + this.paginationData.perPage - 1, users.length - 1);

            users = users.slice(startIndex, endIndex + 1)
            return users;
        },
        setPage(page) {
            if (!Number.isInteger(page)) {
                return
            }

            if (page > 0 && page <= this.paginationData.totalPages) {
                this.paginationData.page = page;
            }
        },
        recountPages(users) {
            let count = Math.ceil(users.length / this.paginationData.perPage)
            this.paginationData.totalPages = count

            if (count > 7) {
                if (this.paginationData.page < 5) {
                    this.paginationData.pages = [1, 2, 3, 4, 5, '...', this.paginationData.totalPages]
                } else if (this.paginationData.page > this.paginationData.totalPages - 4) {
                    this.paginationData.pages = [
                        1, '...',
                        this.paginationData.totalPages - 4,
                        this.paginationData.totalPages - 3,
                        this.paginationData.totalPages - 2,
                        this.paginationData.totalPages - 1,
                        this.paginationData.totalPages
                    ]
                } else {
                    this.paginationData.pages = [
                        1, '...', this.paginationData.page - 1, this.paginationData.page,
                        this.paginationData.page + 1, '...', this.paginationData.totalPages
                    ]
                }
            } else {
                this.paginationData.pages = [1, 2, 3, 4, 5, 6, 7].slice(0, count)
            }
        },

        deleteUser(user) {
            document.getElementById(`delete-user-form-${user.id}`).submit();
        }
    }
}
</script>
