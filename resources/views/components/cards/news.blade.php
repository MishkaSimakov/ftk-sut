<div class="card shadow m-2">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h4 class="d-block font-weight-bold text-primary">
            {{ $current_news->title }}
        </h4>

        <div>
            <h4 class="font-weight-light text-gray-500 mr-3">{{ $current_news->created_at->locale('ru')->isoFormat('D MMMM Y') }}</h4>
        </div>
    </div>

    <div class="card-body">
        <p>{!! $current_news->body !!}</p>
    </div>
</div>

{{--<div class="jumbotron jumbotron-fluid">--}}
{{--    <div class="container">--}}
{{--        <h1 class="display-4">{{ $current_news->title }}</h1>--}}
{{--        <p class="lead">{!! $current_news->body !!}</p>--}}
{{--    </div>--}}
{{--</div>--}}
