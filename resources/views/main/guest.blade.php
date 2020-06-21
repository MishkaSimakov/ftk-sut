@extends('layouts.page')

@section('content')
    <h1 class="epic-text display-1 my-5 text-center">ФТК СЮТ</h1>


    <div id="carouselExampleIndicators" class="mt-2 carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($advantages as $advantage)
                <div class="carousel-item{{ $advantage == $advantages[0] ? ' active' : '' }}">
                    <img class="d-block w-100" src="{{ $advantage['img'] }}" alt="Преймущество клуба ФТК СЮТ">

                    <div class="carousel-caption d-none d-md-block">
                        <h5>Привет мир!</h5>
                        <p>Класс!</p>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
@endsection
