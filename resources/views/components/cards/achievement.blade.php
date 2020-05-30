{{--<div class="achievement card shadow {{ !$achievement->isGetted ? 'achievement__locked' : '' }}">--}}
{{--    <div class="achievement__image_card">--}}
{{--        <img class="achievement__image card-img-top" src="" alt="Изображение от достижения">--}}

{{--        <div class="achievement__locked_icon"><i class="fas fa-lock fa-7x"></i></div>--}}
{{--    </div>--}}

{{--    <div class="card-body">--}}
{{--        <h5 class="card-title">{{ $achievement->name }}</h5>--}}
{{--        <p class="card-text">{{ $achievement->description }}</p>--}}

{{--        @if($studentsCount = $achievement->students->count())--}}
{{--            <p class="card-text text-muted">Это достижение есть у--}}
{{--                {{ round( $studentsCount / \App\Student::all()->count() * 100) }}%--}}
{{--            пользователей</p>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}


<div class="mb-2 card shadow w-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 p-0">
                <img src="{{ $achievement->icon }}" class="h-100 w-100 card-img img-responsive">
            </div>
            <div class="col-md-9 py-2 px-3">
                <div class="card-title">
                    <h5 class="font-weight-bold text-center text-md-left text-primary">
                        {{ $achievement->name }}
                    </h5>
                </div>

                <p>
                    {{ $achievement->description }}
                </p>
            </div>
        </div>
    </div>
</div>
