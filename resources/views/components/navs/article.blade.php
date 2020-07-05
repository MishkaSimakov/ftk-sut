<div class="card mt-2">
    <div class="card-body">
        <ul class="list-unstyled mb-0">
            <li><a href="{{ route('article.index', ['filter' => 'newest']) }}"><i class="fas fa-calendar mr-2"></i>Новые</a></li>
            <li><a href="{{ route('article.index', ['filter' => 'best']) }}"><i class="fas fa-heart mr-2"></i>Популярные</a></li>

            @auth
                <li><a href="{{ route('article.draft') }}"><i class="fas fa-edit mr-2"></i>Черновики</a></li>
            @endauth

            @admin
                <li><a href="{{ route('article.notPublished') }}"><i class="fas fa-check mr-2"></i>Требуют проверки</a></li>
            @endadmin
        </ul>
    </div>
</div>

<div class="card mt-2">
    <div class="card-body">
        <ul class="list-unstyled mb-0">
            <li><a href="{{ route('article.statistics') }}"><i class="fas fa-chart-bar mr-2"></i>Статистика</a></li>
        </ul>
    </div>
</div>
