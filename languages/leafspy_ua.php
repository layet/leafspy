<?php


$dictionary=array(

	'LEAFSPY_SENSOR_BATTERY'=>'Батарея датчика',
	'LEAFSPY_COORDINATES'=>'Coordinates',
	'LEAFSPY_ELEVATION'=>'Координати',
	'LEAFSPY_TRIP_NO'=>'Поїздка',
	'LEAFSPY_TRIP_DIST'=>'Поїздки',
	'LEAFSPY_TRIP_THIS'=>'Ця поїздка',
	'LEAFSPY_TRIP_TOTAL'=>'Всього',
	'LEAFSPY_ODOMETER'=>'Пробіг',
	'LEAFSPY_CAR_BATTERY'=>'Батарея',
	'LEAFSPY_CAR_BATTERY_TEMP'=>'Температура батареї',
	'LEAFSPY_ENGINE_RPM'=>'Обороти двигуна',
	'LEAFSPY_BATTERY_HEALTH'=>'Справність батареї',
	//'LEAFSPY_Speed'=>'Speed',
	'LEAFSPY_BATTERY_VOLTAGE'=>'Напруга батареї',
	'LEAFSPY_BATTERY_CURRENT'=>'Струм батареї',
	'LEAFSPY_BATTERY_CAPACITY'=>'Ємність батареї',
	'LEAFSPY_BATTERY_GIDS'=>'GIDs',
	'LEAFSPY_BATTERY_HX'=>'Hx',
	'LEAFSPY_METER'=>'м',
	'LEAFSPY_KILOMETER'=>'км',
	'LEAFSPY_KILOMETERPERHOUR'=>'км/г',
	'LEAFSPY_VOLT'=>'В',
	'LEAFSPY_AMPER'=>'А',
	'LEAFSPY_CARS'=>'Автомобілі',
	'LEAFSPY_AMPERHOUR'=>'А*г',
	'LEAFSPY_RPM'=>'Обороти',
	'LEAFSPY_KILOWATT'=>'КВт',
	'LEAFSPY_CONFIGURE'=>'Налаштувати',
	'LEAFSPY_MAP'=>'Карта',
	'LEAFSPY_TEMPERATURE' => 'Температура',
	'LEAFSPY_VOLTAGE' => 'Напруга',
	'LEAFSPY_LEFT' => 'зал',
	'LEAFSPY_SHOW_MORE' => 'Детальніше >',
	'LEAFSPY_BACK' => '< Назад',
	'LEAFSPY_ENGINE' => 'Двигун',
	'LEAFSPY_FAST_CHARGING' => 'Швидка зарядка',
	'LEAFSPY_SLOW_CHARGING' => 'Зарядка',
);

foreach ($dictionary as $k=>$v) {
	if (!defined('LANG_'.$k)) {
		define('LANG_'.$k, $v);
	}
}
