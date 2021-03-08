@extends('layouts.app')


@section('title', 'Новости')

@section('app')
    <main style="min-height: 5000px;">
        <img class="position-absolute img-fluid vw-100"
             src="{{ asset('storage/Images/MainPageHeader.png') }}">


        <div class="w-75 mx-auto">
            <div style="height: calc(100vh - 56px - 0.25rem) !important;" class="d-flex flex-column" id="main-page-header">

                <div class="col-7 h-auto my-auto d-flex flex-column">
                    <h1 class="display-1 font-weight-normal">
                        Фототехнический<br>
                        клуб СЮТ
                    </h1>

                    <p class="h2 font-weight-normal">
                        Клуб для самых активных и любознательных<br>
                        детей Волгодонска
                    </p>

                    <div class="row no-gutters mt-auto">
                        <button class="btn btn-primary py-3 px-4">
                             <span class="h1">Подробнее</span>
                        </button>

                        <a href="#" style="cursor: pointer" title="Discord" class="rounded ml-auto mr-2">
                            <img alt="Discord" src="{{ asset('storage/Images/SocialLinks/Discord.png') }}" class="img-fluid">
                        </a>
                        <a href="#" style="cursor: pointer" title="YouTube" class="rounded mr-2">
                            <img alt="YouTube" src="{{ asset('storage/Images/SocialLinks/YouTube.png') }}" class="img-fluid">
                        </a>
                        <a href="#" style="cursor: pointer" title="Вконтакте" class="rounded">
                            <img alt="Вконтакте" src="{{ asset('storage/Images/SocialLinks/VK.png') }}" class="img-fluid">
                        </a>
                    </div>
                </div>


                <section class="w-100">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 border-right d-flex flex-column text-center">
                                    <span class="display-4 font-weight-bolder">452</span>
                                    <span class="h2 font-weight-normal">Ученика</span>
                                </div>

                                <div class="col-md-4 border-right d-flex flex-column text-center">
                                    <span class="display-4 font-weight-bolder">55</span>
                                    <span class="h2 font-weight-normal">Мероприятий</span>
                                </div>

                                <div class="col-md-4 d-flex flex-column text-center">
                                    <span class="display-4 font-weight-bolder">125</span>
                                    <span class="h2 font-weight-normal">Статей</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection
