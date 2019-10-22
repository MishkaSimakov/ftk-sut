<?php

use Carbon\Carbon;

if (!function_exists('getRussianMonth')) {
    function getRussianMonth(Carbon $date, $isGenitive = false)
    {
    	$month = ['Январь', 'Февраль', 'Март', 'Арпель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

    	$genetiveMonth = ['Января', 'Февраля', 'Марта', 'Арпеля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

    	if ($isGenitive) {
    		return $genetiveMonth[$date->month - 1];
    	}

    	return $month[$date->month - 1];
    }
}

if (!function_exists('getRussianWeekday')) {
    function getRussianWeekday(Carbon $date)
    {
    	$weekday = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];

    	return $weekday[$date->dayOfWeek];
    }
}
