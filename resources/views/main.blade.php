@include('partials.header')

 <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1" class=""></li>
          <li data-target="#myCarousel" data-slide-to="2" class=""></li>
        </ol>

        <div class="carousel-inner">
{{--            @foreach($advertisements as $advertisement)--}}
{{--                <div class="col-lg-4">--}}
{{--                    @component('components.cards.advertisement', compact('advertisement'))@endcomponent--}}
{{--                </div>--}}
{{--            @endforeach--}}
        </div>

        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Назад</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Вперёд</span>
        </a>
      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->



<section class="teachers">
    <div class="container">
        <h2 class="section__header">Наши преподаватели</h2>
        <div class="row">
            @foreach($teachers as $teacher)
                <div class="col-lg-4">
                    @component('components.cards.teacher', compact('teacher'))@endcomponent
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="advantages">
    <div class="container">
        <h2 class="sr-only">Наши преимущества</h2>
        <ul class="advantage-list">
            <li class="advantage-list__item">
                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading">Это интересно.</h2>
                        <p class="lead">Ребята изучают материал в интересной форме, строют роботов, составляют алгоритмы, и никогда не скучают, ведь здесь огромный простор для фантазии! А те кто уже хорошо изучил это направление могут участвовать в городских, областных и международных соревнованиях, путешествуя по разным городам и приобретая интересный опыт!</p>
                    </div>
                    <div class="col-md-5">
                        <img class="featurette-image img-fluid mx-auto rounded" data-src="holder.js/500x500/auto" alt="500x500" style="width: 500px; height: 500px; object-fit: cover;" src="https://sun9-20.userapi.com/c840434/v840434567/88fd7/kz6EHCMix9M.jpg" data-holder-rendered="true">
                    </div>
                </div>
            </li>
            <li class="advantage-list__item">
                <div class="row featurette">
                    <div class="col-md-7 order-md-2">
                        <h2 class="featurette-heading">Это полезно.</h2>
                        <p class="lead">Соблюдаются все условия для поддержания здоровья вашего ребёнка. На занятиях проводяться разминки, каждую субботу проходят интереснейшие развлекательные и интеллектуальные мероприятия, а по воскресеньям ребята отправляются в походы, чтобы лучше знать свой город и его окресности.</p>
                    </div>
                    <div class="col-md-5 order-md-1">
                        <img class="featurette-image img-fluid mx-auto rounded" data-src="holder.js/500x500/auto" alt="500x500" src="https://sun9-7.userapi.com/c851024/v851024995/15bc92/RW1nu-vZB3M.jpg" data-holder-rendered="true" style="width: 500px; height: 500px; object-fit: cover;">
                    </div>
                </div>
            </li>
            <li class="advantage-list__item">
                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading">И конечно же познавательно!</h2>
                        <p class="lead">Опытные преподаватели и уникальные методики делают обучение не только интересным, но и познавательным! В младших группах дети обучаются простейшим алгоритмам, основам моделирования и конструирования. В средних группах всё становиться сложнее - ребята изучают более сложные темы. Ну а в старших группах всё сложно, но интересно. Приходите и изучите всё сами!</p>
                    </div>
                    <div class="col-md-5">
                        <img class="featurette-image img-fluid mx-auto rounded" data-src="holder.js/500x500/auto" alt="500x500" src="https://sun9-18.userapi.com/c837223/v837223192/35628/BF1-k5cBwt4.jpg" data-holder-rendered="true" style="width: 500px; height: 500px; object-fit: cover;">
                    </div>
                </div>
            </li>
        </ul>
    </div>
</section>

<section class="contacts">
    <div class="container">
        <h2>Как же нас найти?</h2>
        <p><i class="fas fa-envelope mr-2"></i>msimakov661@gmail.com</p>
        <p><i class="fab fa-vk mr-2"></i><a href="https://vk.com/ftksut">https://vk.com/ftksut</a></p>
        <p><i class="fas fa-phone mr-2"></i>+7(989) 709-14-84</p>
        <p><i class="fas fa-map-marker-alt mr-2"></i>пр. Курчатова, 47</p>
    </div>
</section>

  <!-- FOOTER -->
<footer class="container">
    <p>© {{ Carbon\Carbon::now()->year }} <a href="https://vk.com/simakovkin">Mishka Simakov</a></p>
</footer>

<script type="text/javascript">
    $('.slide-image').each(function() {
        $(this).height($(window).height() - $('.header-nav').height());
    })
</script>

@include('partials.footer')
