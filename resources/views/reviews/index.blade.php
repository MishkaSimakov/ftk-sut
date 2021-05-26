@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Отзывы')

@section('content')
    <h1 class="text-center mb-4">Отзывы</h1>

    @foreach($reviews as $review)
        <div class="card mb-3">
            <div class="card-body">
                {{ $review->body }}
            </div>

            <div class="card-footer">
                <div class="row no-gutters text-secondary">
                    <div>
                    {{ $review->email }}
                    </div>
                    <div class="ml-auto">
                        {{ $review->created_at->isoFormat('ll HH:mm') }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
