<footer class="footer">
    <nav class="footer__wrapper">
        <div class="footer__contacts contacts">
            <a class="contacts__link--main" href="#">фтк сют</a>
            <a href="https://vk.com/ftksut" class="contacts__link--vk" target="_blank">
                <span class="contacts__link--vk__block fab fa-vk" aria-hidden="true"></span>
                <span class="contacts__link--vk__title">Наша группа Вконтакте</span>
            </a>
            <div class="contacts__telephone">
                <span class="contacts__telephone--title">Контактный телефон:</span>
                <span class="contacts__telephone--number">+7 (8639) 24-28-21</span>
            </div>
            <div class="contacts__address">
                <span class="contacts__address--title">Адрес:</span>
                <span class="contacts__address--position">пр. Курчатова, 47,<br>
                                                    подъезд 1, этаж 1</span>
                <a href="https://yandex.ru/maps/-/CGd~eEpW" class="contacts__address--map" target="_blank">Показать на карте</a>
            </div>
        </div>

        <ul class="footer__navigation">
            <li class="footer__navigation__item"><a href="#" class="footer__navigation__link">Рейтинг</a></li>
            <li class="footer__navigation__item"><a href="#" class="footer__navigation__link">Достижения</a></li>
            <li class="footer__navigation__item"><a href="#" class="footer__navigation__link">Статьи</a></li>
            <li class="footer__navigation__item"><a href="#" class="footer__navigation__link">Расписание</a></li>
            <li class="footer__navigation__item"><a href="#" class="footer__navigation__link">Панель администратора</a></li>
        </ul>
    </nav>

    <div class="footer__copyright copyright">
        <p class="copyright__title"><span class="copyright__letter">©</span> {{ now()->year }}</p>
        <ul class="copyright__authors">
            <li class="copyright__author"><a href="https://vk.com/devdimaorg" class="copyright__author__link">Дмитрий Буглак</a></li>
            <li class="copyright__author"><a href="https://vk.com/simakovkin" class="copyright__author__link">Михаил Симаков</a></li>
        </ul>
    </div>
</footer>
