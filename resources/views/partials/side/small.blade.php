<div class="col-6 p-0 position-fixed" style="z-index: 100; display: none; top: 0; left: 0;" id="small_sidebar">
    <div class="bg-light pt-2 p-3 vh-100">
        <div class="w-100 text-center">
            <a href="{{ route('main') }}" class="h3 font-weight-bolder mb-2">ФТК СЮТ</a>
        </div>

        <ul class="nav flex-column flex-nowrap overflow-hidden">
            <li><a href="{{ route('news.index') }}"><i class="fas fa-newspaper mr-2"></i>Новости</a></li>
            <li><a href="{{ route('schedule.index') }}"><i class="fas fa-calendar-alt mr-2"></i>Расписание</a></li>
            <li><a href="{{ route('article.index') }}"><i class="fas fa-pen mr-2"></i>Статьи</a></li>

            @auth
                <chat-button url="{{ route('chat.index') }}"></chat-button>
            @endauth

            <li><a href="{{ route('rating.index') }}"><i class="fas fa-align-left mr-2"></i>Рейтинг</a></li>
            <li><a href="{{ route('achievements.index') }}"><i class="fas fa-star mr-2"></i>Достижения</a></li>

            @admin
                <li><a href="{{ route('admin.index') }}"><i class="fas fa-wrench mr-2"></i>Панель</a></li>
            @endadmin
        </ul>
    </div>
</div>
