@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Рейтинг')
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')
    <h1 class="text-center mb-4">Удалить рейтинг</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('rating.destroy') }}" method="POST">
                @csrf
                @method('DELETE')

                 <div class="form-group">
                     <label for="date_start">Дата начала удаления</label>
                     <input id="date_start" type="month"
                            class="form-control @error('date_start') is-invalid @enderror" name="date_start"
                            value="{{ old('date_start') }}" required autofocus
                     >

                     @error('date_start')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label for="date_end">Дата окончания удаления</label>
                     <input id="date_end" type="month"
                            class="form-control @error('date_end') is-invalid @enderror" name="date_end"
                            value="{{ old('date_end') }}" required autofocus
                     >

                     @error('date_end')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                <button type="submit" class="btn btn-danger mr-2">Удалить</button>
            </form>
        </div>
    </div>
@endsection
