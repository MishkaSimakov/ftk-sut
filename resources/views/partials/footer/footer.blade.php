<footer>
    <div class="mx-2">
        <hr class="mb-0">

        <div class="ml-3 float-left">
            <a href="{{ route('main') }}" class="text-muted">Главная</a>
        </div>

        <div class="mr-3 text-muted float-right">
            <a href="https://vk.com/ftksut" class="text-muted mr-2">Группа ВК</a>

            <div class="dropdown dropup d-inline">
                <a href="#" class="text-muted" id="creators" data-toggle="dropdown" data-boundary="window">
                    Создатели
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="https://vk.com/simakovkin">Симаков Михаил</a>
                    <a class="dropdown-item" href="https://vk.com/quanz">Даричев Егор</a>

                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Отдельная благодарность</h6>
                    <a class="dropdown-item">Игорь Вячеславович<br> Маркин</a>
            </div>
            </div>
        </div>
    </div>
</footer>

{{--@push('script')--}}
{{--    <script>--}}
{{--        // $('.dropdown-toggle').dropdown( )--}}
{{--    </script>--}}
{{--@endpush--}}
