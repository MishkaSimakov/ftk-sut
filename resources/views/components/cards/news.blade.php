<div class="card shadow mb-2">
    <div class="card-body p-2">
        <p class="float-right text-muted">{{ $current_news->created_at->locale('ru')->isoFormat('D MMMM Y') }}</p>
        <h3 class="text-center">{{ $current_news->title }}</h3>

        <p>{!! $current_news->body !!}</p>

        <div class="float-right h5 m-0">
            <a class="article__comment_link">
                <i class="far fa-eye"></i>
            </a>

            <span class="article__comments_counter">
                {{ views($current_news)->count() }}
            </span>
        </div>
    </div>
</div>

{{--@admin--}}
{{--<div class="float-right row">--}}
{{--    <div class="dropdown no-gutters">--}}
{{--        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>--}}
{{--        </a>--}}
{{--        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">--}}
{{--            <div class="dropdown-header font-weight-bold">Дополнительно:</div>--}}
{{--            <a class="dropdown-item" href="{{ route('news.edit', $current_news) }}">--}}
{{--                Редактировать--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endadmin--}}
