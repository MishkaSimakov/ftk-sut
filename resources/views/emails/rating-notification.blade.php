@component('mail::message')
# Новый рейтинг на сайте <a href="{{ route('main') }}" target="_blank">ФТК СЮТ</a>

@component('mail::panel')
## Рейтинг за {{ $date->isoFormat('MMMM YYYY') }}
@endcomponent

@component('mail::button', ['url' => route('rating.index'), 'color' => 'success'])
Посмотреть рейтинг
@endcomponent
@endcomponent
