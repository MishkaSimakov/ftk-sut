<ul class="advantage-list">
    @foreach($advantages as $advantage)
        <li class="advantage-list__item advantage">
            <div class="row advantage__wrapper">
                <div class="col-md-7 advantage__text">
                    <h2>{{ $advantage['header'] }}</h2>
                    <p class="lead">{{ $advantage['body'] }}</p>
                </div>

                <div class="col-md-5 advantage__image-wrapper">
                    <img class="rounded advantage__image"
                         alt="{{ $advantage['header'] }}"
                         src="{{ $advantage['img'] }}"
                    >
                </div>
            </div>
        </li>
    @endforeach
</ul>
