<div class="nav-scroller bg-white shadow-sm">
    <nav class="nav nav-underline">
        <a class="nav-link" href="{{ route('article.index') }}?filter=best">Лучшее</a>
        <a class="nav-link" href="{{ route('article.index') }}?filter=newest">Новейшее</a>
        @auth
            @if (Auth::user()->is_admin)
                <a class="nav-link" href="{{ route('article.notPublished') }}">
                    Требуют проверки
                    <span class="badge badge-pill bg-light align-text-bottom">{{ $notPublishedCount }}</span>
                </a>
            @endif
        @endauth
    </nav>
</div>

<style>
    td {
        border: 2px solid lightgrey !important;
        border-collapse: collapse;
    }

    blockquote {
        border-left: 5px solid rgb(204, 204, 204);
        box-sizing: border-box;
        color: rgb(33, 37, 41);
        font-style: italic;
        margin-top: 12.96px;
        overflow-wrap: break-word;
        overflow-x: hidden;
        overflow-y: hidden;
        padding-left: 21.6px;
        text-align: left;
    }
</style>
