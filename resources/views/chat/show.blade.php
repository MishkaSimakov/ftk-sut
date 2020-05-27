@extends('layouts.page')

@section('content')
    <chat id="{{ $chat->id }}"></chat>
@endsection

@push('side')
    <div class="card mt-2">
        <div class="card-body">
            <chat-users></chat-users>
        </div>
    </div>
@endpush
