<?php


$dictionary=array(

	'LEAFSPY_SENSOR_BATTERY'=>'Sensor Battery',
	'LEAFSPY_COORDINATES'=>'Coordinates',
	'LEAFSPY_ELEVATION'=>'Elevation',
	'LEAFSPY_TRIP_NO'=>'Trip No',
	'LEAFSPY_TRIP_DIST'=>'Trip distance',
	'LEAFSPY_TRIP_THIS'=>'This trip',
	'LEAFSPY_TRIP_TOTAL'=>'Total',
	'LEAFSPY_ODOMETER'=>'Odometer',
	'LEAFSPY_CAR_BATTERY'=>'Battery',
	'LEAFSPY_CAR_BATTERY_TEMP'=>'Battery Temperature',
	'LEAFSPY_ENGINE_RPM'=>'Engine RPM',
	'LEAFSPY_BATTERY_HEALTH'=>'Battery health',
	//'LEAFSPY_Speed'=>'Speed',
	'LEAFSPY_BATTERY_VOLTAGE'=>'Battery voltage',
	'LEAFSPY_BATTERY_CURRENT'=>'Battery current',
	'LEAFSPY_BATTERY_CAPACITY'=>'Battery capacity',
	'LEAFSPY_BATTERY_GIDS'=>'GIDs',
	'LEAFSPY_BATTERY_HX'=>'Hx',
	'LEAFSPY_METER'=>'m',
	'LEAFSPY_KILOMETER'=>'km',
	'LEAFSPY_KILOMETERPERHOUR'=>'km/h',
	'LEAFSPY_VOLT'=>'V',
	'LEAFSPY_AMPER'=>'A',
	'LEAFSPY_CARS'=>'Cars',
	'LEAFSPY_AMPERHOUR'=>'AHr',
	'LEAFSPY_RPM'=>'Rpm',
	'LEAFSPY_KILOWATT'=>'KW',
	'LEAFSPY_CONFIGURE'=>'Configure',
	'LEAFSPY_MAP'=>'Map',
	'LEAFSPY_TEMPERATURE' => 'Temperature',
	'LEAFSPY_VOLTAGE' => 'Voltage',
	'LEAFSPY_LEFT' => 'left',
	'LEAFSPY_SHOW_MORE' => 'Show more >',
	'LEAFSPY_BACK' => '< Back',
	'LEAFSPY_ENGINE' => 'Engine',
	'LEAFSPY_FAST_CHARGING' => 'Fast Charging',
	'LEAFSPY_SLOW_CHARGING' => 'Charging',

);

foreach ($dictionary as $k=>$v) {
	if (!defined('LANG_'.$k)) {
		define('LANG_'.$k, $v);
	}
}
