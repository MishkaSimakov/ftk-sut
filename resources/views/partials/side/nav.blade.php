<div class="card mt-2">
    <div class="card-body">
        <ul class="list-unstyled mb-0">
            <li><a href="{{ route('about') }}"><i class="fas fa-info-circle mr-2"></i>О нас</a></li>

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

@push('script')
    <script>
        let lastScrollTop = 0;

        $(window).scroll(function() {
            let sidebar = $('#sidebar');
            let bottom = Math.min(0, -$(this).scrollTop());

            sidebar.css('bottom', bottom + 'px')
        });
    </script>
@endpush