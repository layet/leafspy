<?php


$dictionary=array(

	'LEAFSPY_SENSOR_BATTERY'=>'Батарея сенсора',
	'LEAFSPY_COORDINATES'=>'Координаты',
	'LEAFSPY_ELEVATION'=>'Высота',
	'LEAFSPY_TRIP_NO'=>'Поездка',
	'LEAFSPY_TRIP_DIST'=>'Поездки',
	'LEAFSPY_TRIP_THIS'=>'Последняя',
	'LEAFSPY_TRIP_TOTAL'=>'Всего',
	'LEAFSPY_ODOMETER'=>'Пробег',
	'LEAFSPY_CAR_BATTERY'=>'Батарея',
	'LEAFSPY_CAR_BATTERY_TEMP'=>'Температура батареи',
	'LEAFSPY_ENGINE_RPM'=>'Обороты двигателя',
	'LEAFSPY_BATTERY_HEALTH'=>'Здоровье батареи',
	'LEAFSPY_BATTERY_VOLTAGE'=>'Напряжение батареи',
	'LEAFSPY_BATTERY_CURRENT'=>'Ток батареи',
	'LEAFSPY_BATTERY_CAPACITY'=>'Ёмкость батареи',
	'LEAFSPY_BATTERY_GIDS'=>'GIDs',
	'LEAFSPY_BATTERY_HX'=>'Hx',
	'LEAFSPY_METER'=>'м',
	'LEAFSPY_KILOMETER'=>'км',
	'LEAFSPY_KILOMETERPERHOUR'=>'км/ч',
	'LEAFSPY_VOLT'=>'В',
	'LEAFSPY_AMPER'=>'А',
	'LEAFSPY_CARS'=>'Машины',
	'LEAFSPY_AMPERHOUR'=>'А*ч',
	'LEAFSPY_RPM'=>'Rpm',
	'LEAFSPY_KILOWATT'=>'КВт',
	'LEAFSPY_CONFIGURE'=>'Настройки',
	'LEAFSPY_MAP'=>'Map',
	'LEAFSPY_TEMPERATURE' => 'Температура',
	'LEAFSPY_VOLTAGE' => 'Напряжение',
	'LEAFSPY_LEFT' => 'ч:м',
	'LEAFSPY_SHOW_MORE' => 'Подробнее >',
	'LEAFSPY_BACK' => '< Назад',
	'LEAFSPY_ENGINE' => 'Двигатель',
	'LEAFSPY_FAST_CHARGING' => 'Быстрая зарядка',
	'LEAFSPY_SLOW_CHARGING' => 'Зарядка',
);

foreach ($dictionary as $k=>$v) {
	if (!defined('LANG_'.$k)) {
		define('LANG_'.$k, $v);
	}
}
