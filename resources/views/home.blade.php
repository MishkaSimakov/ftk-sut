@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">{{ $user->name }}</h1>

    <div class="container">
        <div class="card-deck">
            <div class="col-md-6 col-sm-11 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Достижения</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" style="color: #5a5c69 !important;">{{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-trophy fa-2x text-gray-300" style="color: #dddfeb !important;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-11 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Статьи</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user->articles->count() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-newspaper fa-2x text-gray-300" style="color: #dddfeb !important;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

{{--            TODO: Добавить ещё 2 таких блока и придумать, что в них писать --}}
{{--            <div class="col-xl-3 col-md-6 mb-4">--}}
{{--                <div class="card border-left-secondary shadow h-100 py-2">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row no-gutters align-items-center">--}}
{{--                            <div class="col mr-2">--}}
{{--                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Статьи</div>--}}
{{--                                <div class="row no-gutters align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="progress progress-sm mr-2">--}}
{{--                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto">--}}
{{--                                <i class="fas fa-trophy fa-2x text-gray-300"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-xl-3 col-md-6 mb-4">--}}
{{--                <div class="card border-left-secondary shadow h-100 py-2">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row no-gutters align-items-center">--}}
{{--                            <div class="col mr-2">--}}
{{--                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Статьи</div>--}}
{{--                                <div class="row no-gutters align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="progress progress-sm mr-2">--}}
{{--                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto">--}}
{{--                                <i class="fas fa-trophy fa-2x text-gray-300"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>

        <div class="card-deck mb-4">
            @if ($user->description)
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4 class="font-weight-bold text-primary">О себе</h4>
                        </div>

                        <div class="card-body">
                            {!! $user->description !!}
                        </div>
                    </div>
                </div>
            @endif

            @if (!$user->articles->isEmpty())
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4 class="font-weight-bold text-primary">Статьи</h4>
                        </div>

                        <div class="card-body">
                            @foreach($user->articles as $article)
                                <h5><a href="{{ $article->url }}">{{ \Illuminate\Support\Str::limit($article->title, 45, '...') }}</a></h5>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="card-deck mb-4">
            @if ($achievements)
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4 class="font-weight-bold text-primary">Достижения</h4>
                        </div>

                        <div class="card-body">
                            @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

{{--@extends('layouts.page')--}}

{{--@section('content')--}}
{{--    <h1 class="text-center m-2">{{ Auth::user()->name }}</h1>--}}

{{--    @if ($achievements)--}}
{{--        @component('components.sections.section', ['header' => 'Достижения'])--}}
{{--            @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent--}}
{{--        @endcomponent--}}
{{--    @endif--}}
{{--@endsection--}}

