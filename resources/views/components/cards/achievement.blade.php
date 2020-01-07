<div class="achievement card {{ !$achievement->isGetted ? 'achievement__locked' : '' }}">
    <div class="achievement__image_card">
        <img class="achievement__image card-img-top" src="{{ $achievement->icon }}" alt="Изображение от достижения">

        @if (!$achievement->isGetted)
            <div class="achievement__locked_icon"><i class="fas fa-lock fa-7x"></i></div>
        @endif
    </div>

    <div class="card-body">
        <h5 class="card-title">{{ $achievement->name }}</h5>
        <p class="card-text">{{ $achievement->description }}</p>
    </div>
</div>
