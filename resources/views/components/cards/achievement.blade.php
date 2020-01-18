<div class="achievement card {{ !$achievement->isGetted ? 'achievement__locked' : '' }}">
    <div class="achievement__image_card">
        <img class="achievement__image card-img-top" src="{{ $achievement->icon }}" alt="Изображение от достижения">

        <div class="achievement__locked_icon"><i class="fas fa-lock fa-7x"></i></div>
    </div>

    <div class="card-body">
        <h5 class="card-title">{{ $achievement->name }}</h5>
        <p class="card-text">{{ $achievement->description }}</p>

        <p class="card-text text-muted">Это достижение есть у {{ round($achievement->students->count() / \App\Student::all()->count() * 100) }}% пользователей</p>
    </div>
</div>
