@component('mail::message')
# Новая новость на сайте <a href="{{ route('main') }}" target="_blank">ФТК СЮТ</a>

@component('mail::panel')
## {{ $news->title }}

{!! $news->body !!}
@endcomponent

@component('mail::button', ['url' => route('news.index'), 'color' => 'success'])
    Посмотреть все новости
@endcomponent


## На сайте вы также можете посмотреть:
- <a href="{{ route('article.index') }}" target="_blank">статьи</a>
- <a href="{{ route('rating.index') }}" target="_blank">рейтинг</a>
- <a href="{{ route('events.index') }}" target="_blank">расписание</a>
@endcomponent
