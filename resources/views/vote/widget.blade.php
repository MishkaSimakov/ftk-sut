@extends('layouts.page', ['nav' => 'none'])

@section('content')
    <vote active="{{ auth()->check() }}" data="{{ $vote->toJson() }}"></vote>
@endsection
