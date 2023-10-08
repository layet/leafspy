<?php

include_once("./config.php");
include_once("./lib/loader.php");
include_once(DIR_MODULES . "application.class.php");
include_once(DIR_MODULES . "leafspy/leafspy.class.php");

$rec = array();

$rec['DEVBAT'] = $_REQUEST['DevBat'];
$rec['GIDS'] = $_REQUEST['Gids'];
$rec['LAT'] = $_REQUEST['Lat'];
$rec['LONG'] = $_REQUEST['Long'];
$rec['ELV'] = $_REQUEST['Elv'];
$rec['SEQ'] = $_REQUEST['Seq'];
$rec['TRIP'] = $_REQUEST['Trip'];
$rec['ODO'] = $_REQUEST['Odo'];
$rec['SOC'] = round($_REQUEST['SOC'], 2);
$rec['AHR'] = round($_REQUEST['AHr'], 2);
$rec['BATTEMP'] = $_REQUEST['BatTemp'];
$rec['AMB'] = $_REQUEST['Amb'];
$rec['WPR'] = $_REQUEST['Wpr'];
$rec['PLUGSTATE'] = $_REQUEST['PlugState'];
$rec['CHRGMODE'] = $_REQUEST['ChrgMode'];
$rec['CHRGPWR'] = $_REQUEST['ChrgPwr'];
$rec['VIN'] = $_REQUEST['VIN'];
$rec['PWRSW'] = $_REQUEST['PwrSw'];
$rec['RPM'] = $_REQUEST['RPM'];
$rec['SOH'] = $_REQUEST['SOH'];
$rec['HX'] = $_REQUEST['Hx'];
$rec['SPEED'] = $_REQUEST['Speed'];
$rec['BATVOLTS'] = $_REQUEST['BatVolts'];
$rec['BATAMPS'] = $_REQUEST['BatAmps'];
$rec['TUNITS'] = $_REQUEST['Tunits'];

$leafspy = new leafspy();

$car_id = $leafspy->getCarIdByVIN($rec['VIN']);
print_r($car_id);
if (!$car_id) {
   $leafspy->insertNewCar($rec);
} else {
   $leafspy->updateCarData($car_id, $rec);
}