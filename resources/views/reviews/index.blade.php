@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Отзывы')
@section('description', '')
@section('robots', 'noindex, follow')

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
                        {{ $review->email }} • {{ $review->created_at->isoFormat('ll HH:mm') }}
                    </div>

                    <div class="ml-auto">
                        <a
                            class="text-danger"
                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $review->id }}').submit();"
                            href="#"
                        >
                            Удалить
                        </a>
                        <form method="POST" id="delete-form-{{ $review->id }}"
                              action="{{ route('reviews.destroy', $review) }}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
