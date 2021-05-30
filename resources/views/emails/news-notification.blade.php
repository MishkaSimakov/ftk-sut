@component('mail::message')
# Новая новость на сайте <a href="{{ route('main') }}" target="_blank">ФТК СЮТ</a>

@component('mail::panel')
## {{ $news->title }}

{!! $news->body !!}
@endcomponent

@component('mail::button', ['url' => route('news.index'), 'color' => 'success'])
Посмотреть все новости
@endcomponent
@endcomponent
