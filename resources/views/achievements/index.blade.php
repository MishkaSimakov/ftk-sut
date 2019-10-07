@include('partials.header')

<h1 class="text-center m-2">Достижения</h1>

<div class="text-center">
  @foreach($achievements as $achievement)
    <div class="card m-3 d-inline-block" style="width: 18rem">
      @if($achievement->isGetted)
        <img class="card-img-top" src="{{ $achievement->icon }}" alt="Изображение от достижения">

        <div class="card-body">
          <h5 class="card-title">{{ $achievement->name }}</h5>
          <p class="card-text">{{ $achievement->description }}</p>
        </div>
      @else
        <div style="opacity: 0.5">
          <div style="position: relative; text-align: center; color: white;">
            <img class="card-img-top" src="{{ $achievement->icon }}" alt="Изображение от достижения">

            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"><i class="fas fa-lock fa-7x"></i></div>
          </div>

          <div class="card-body">
            <h5 class="card-title">{{ $achievement->name }}</h5>
            <p class="card-text">{{ $achievement->description }}</p>
          </div>
        </div>
      @endif
    </div>
  @endforeach
</div>

@include('partials.footer')
