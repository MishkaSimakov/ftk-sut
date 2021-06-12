@component('mail::message')
# Новая статья на сайте <a href="{{ route('main') }}" target="_blank">ФТК СЮТ</a>

@component('mail::panel')
## {{ $article->title }}

_Автор - <a href="{{ route('users.show', $article->author) }}" target="_blank">{{ $article->author->name }}</a>_
@endcomponent

@component('mail::button', ['url' => route('articles.index'), 'color' => 'success'])
Посмотреть все статьи
@endcomponent
@endcomponent
