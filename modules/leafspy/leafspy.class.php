<?php
/**
* Leaf Spy 
* @package project
* @author Wizard <sergejey@gmail.com>
* @copyright http://majordomo.smartliving.ru/ (c)
* @version 0.1 (wizard, 08:09:10 [Sep 06, 2023])
*/
//
//
class leafspy extends module {
/**
* leafspy
*
* Module class constructor
*
* @access private
*/
function __construct() {
  $this->name="leafspy";
  $this->title="Leaf Spy";
  $this->module_category="<#LANG_SECTION_DEVICES#>";
  $this->checkInstalled();
}
/**
* saveParams
*
* Saving module parameters
*
* @access public
*/
function saveParams($data=1) {
 $p=array();
 if (IsSet($this->id)) {
  $p["id"]=$this->id;
 }
 if (IsSet($this->view_mode)) {
  $p["view_mode"]=$this->view_mode;
 }
 if (IsSet($this->edit_mode)) {
  $p["edit_mode"]=$this->edit_mode;
 }
 if (IsSet($this->tab)) {
  $p["tab"]=$this->tab;
 }
 return parent::saveParams($p);
}
/**
* getParams
*
* Getting module parameters from query string
*
* @access public
*/
function getParams() {
  global $id;
  global $mode;
  global $view_mode;
  global $edit_mode;
  global $tab;
  global $data_source;
  if (isset($id)) {
   $this->id=$id;
  }
  if (isset($mode)) {
   $this->mode=$mode;
  }
  if (isset($view_mode)) {
   $this->view_mode=$view_mode;
  }
  if (isset($edit_mode)) {
   $this->edit_mode=$edit_mode;
  }
  if (isset($tab)) {
   $this->tab=$tab;
  }
  if (isset($data_source)) {
	$this->data_source = $data_source;
  }
}
/**
* Run
*
* Description
*
* @access public
*/
function run() {
 global $session;
  $out=array();
  if ($this->action=='admin') {
   $this->admin($out);
  } else {
   $this->usual($out);
  }
  if (IsSet($this->owner->action)) {
   $out['PARENT_ACTION']=$this->owner->action;
  }
  if (IsSet($this->owner->name)) {
   $out['PARENT_NAME']=$this->owner->name;
  }
  $out['DATA_SOURCE'] = $this->data_source;
  $out['VIEW_MODE']=$this->view_mode;
  $out['EDIT_MODE']=$this->edit_mode;
  $out['MODE']=$this->mode;
  $out['ACTION']=$this->action;
  $out['TAB']=$this->tab;
  $this->data=$out;
  $p=new parser(DIR_TEMPLATES.$this->name."/".$this->name.".html", $this->data, $this);
  $this->result=$p->result;
}
/**
* BackEnd
*
* Module backend
*
* @access public
*/
function admin(&$out) {
	if (isset($this->data_source) && !$_GET['data_source'] && !$_POST['data_source']) {
		$out['SET_DATASOURCE']=1;
	}
    if ($this->data_source=='data') {
	    if ($this->view_mode=='' || $this->view_mode=='search_leaf_spy') {
	        $this->search_leaf_spy($out);
	    }
	    if ($this->view_mode=='delete_leaf_spy') {
	        $this->delete_leaf_spy($this->id);
	        $this->redirect("?data_source=data");
	    }
    }
    if ($this->data_source=='cars' || $this->data_source=='') {
	    if ($this->view_mode=='') {
		    $query_text = "select c.`ID`, c.`DEVBAT`, c.`LAT`, c.`LONG`, c.`ELV`, c.`TRIP`, c.`ODO`, ROUND(c.`SOC`) AS `SOC`, (100-ROUND(c.`SOC`))*1.6 AS `SOC_Y`, 160-((100-ROUND(c.`SOC`))*1.6) AS `SOC_HEIGHT`,
							c.`BATTEMP`, c.`RPM`, c.`SOH`, ROUND(c.`SPEED`*3.6) AS `SPEED`, c.`BATVOLTS`, ROUND(c.`BATAMPS`, 1) AS `BATAMPS`, c.`CREATEDON`, ROUND(c.`AHR`,1) AS `AHR`,
       						c.`TUNITS`, c.`VIN`, c.`HX`, c.`CHRGMODE`, ROUND(c.`CHRGPWR`/1000, 1) AS `CHRGPWR`,
							ROUND(c.`BATAMPS`*`BATVOLTS`/1000) AS `ENGINE_CONSUMPTION`, tr.`DIST`, ROUND(c.`SOC`/(tr.`BAT_CONSUMPTION`/tr.`DIST`)) AS `EST_KILOMETERAGE`,
					        time_format(sec_to_time(abs((ch.`maxsoc` - c.`SOC`)/ch.`percpermin`)), '%H:%i') as `EST_CHARGING_TIME`
					        from `leaf_spy_cars` c
							left join (
								SELECT c.`VIN`, max(`ODO`) - min(`ODO`) as `DIST`, max(`SOC`) - min(`SOC`) as `BAT_CONSUMPTION` FROM db_terminal.leaf_spy c
								join (select `VIN`, max(`TRIP`) as `_max` from db_terminal.leaf_spy where `CHRGMODE` = 0 group by `VIN`) l on l.`VIN` = c.`VIN`
								where c.`TRIP` = l.`_max`
							    group by c.`VIN`
							) tr on tr.`VIN` = c.`VIN`
							left join (
								SELECT c.`VIN`, max(`SOC`) as maxsoc, (max(`SOC`) - min(`SOC`)) / timestampdiff(second, min(`CREATEDON`), max(`CREATEDON`)) as percpermin FROM db_terminal.leaf_spy c
								join (select `VIN`, max(`TRIP`) as `_max` from db_terminal.leaf_spy where `CHRGMODE` != 0 group by `VIN`) l on l.`VIN` = c.`VIN`
								where c.`TRIP` = l.`_max`
							    group by c.`VIN`
							) ch on ch.`VIN` = c.`VIN` ";
	    	$result = SQLSelect($query_text);

		    if ($result) {
			    $out['RESULT'] = $result;
		    }
	    }
	    if ($this->view_mode=='configure') {
		    $this->edit_leaf_spy_car($out, $this->id);
	    }
	    if ($this->view_mode=='delete') {
		    $this->delete_leaf_spy_car($this->id);
		    $this->redirect("?data_source=cars");
	    }
    }
}
/**
* FrontEnd
*
* Module frontend
*
* @access public
*/
function usual(&$out) {
 $this->admin($out);
}
/**
* leaf_spy search
*
* @access public
*/
 function search_leaf_spy(&$out) {
  require(dirname(__FILE__).'/leaf_spy_search.inc.php');
 }
/**
 * leaf_spy delete record
 *
 * @access public
 */
function delete_leaf_spy($id) {
	SQLExec("DELETE FROM leaf_spy WHERE ID=".DbSafe1($id));
}
/**
* leaf_spy edit/add
*
* @access public
*/
 function edit_leaf_spy_car(&$out, $id) {
  require(dirname(__FILE__).'/leaf_spy_edit.inc.php');
 }

function delete_leaf_spy_car($id) {
	SQLExec("DELETE FROM leaf_spy_properties WHERE CAR_ID=".DbSafe1($id));
	SQLExec("DELETE FROM leaf_spy_cars WHERE ID=".DbSafe1($id));
}

function getCarIdByVIN($VIN) {
	return SQLSelectOne('select `Id` from `leaf_spy_cars` where `VIN` = \''.DbSafe($VIN).'\'')['Id'];
}

function insertNewCar($data) {
	$car_id = SQLInsert('leaf_spy_cars', $data);

	foreach ($data as $item => $value) {
		SQLExec( 'insert into `leaf_spy_properties` (`CAR_ID`, `PROPERTY`, `VALUE`) VALUES ('.$car_id.', \''.$item.'\', \''.$value.'\')');
	}
}

 function updateCarData($car_id, $data) {
 	//SQLInsert('leaf_spy', $data);

 	$data['ID'] = $car_id;
	SQLUpdate('leaf_spy_cars', $data);

	foreach ($data as $item => $value) {
		SQLExec( 'update `leaf_spy_properties` set `VALUE` = \''.$value.'\', `UPDATEDON` = current_timestamp() WHERE `CAR_ID` = '.$car_id.' and `PROPERTY` = \''.DbSafe($item).'\'');
	}
	$properties = SQLSelect('select PROPERTY,VALUE,LINKED_OBJECT,LINKED_PROPERTY,LINKED_METHOD from leaf_spy_properties where ifnull(LINKED_OBJECT,\'\') != \'\'  and CAR_ID='.$car_id);

	foreach ($properties as $item) {
		if ($item['LINKED_PROPERTY']) SetGlobal($item['LINKED_OBJECT'].'.'.$item['LINKED_PROPERTY'], $item['VALUE'], 0, '/leaf.php');
		if ($item['LINKED_METHOD'])  {
			$params = array();
			$params['VALUE'] = $item['VALUE'];
			callMethodSafe($item['LINKED_OBJECT'] . '.' . $item['LINKED_METHOD'], $params);
		}
	}
 }
/**
* Install
*
* Module installation routine
*
* @access private
*/
 function install($data='') {
  parent::install();
 }
/**
* Uninstall
*
* Module uninstall routine
*
* @access public
*/
 function uninstall() {
	SQLExec('DROP TABLE IF EXISTS leaf_spy');
	SQLExec('DROP TABLE IF EXISTS leaf_spy_cars');
	SQLExec('DROP TABLE IF EXISTS leaf_spy_properties');
	parent::uninstall();
 }
/**
* dbInstall
*
* Database installation routine
*
* @access private
*/
 function dbInstall($data) {
/*
leaf_spy - 
*/
  $data = <<<EOD
 leaf_spy: ID int(10) unsigned NOT NULL auto_increment
 leaf_spy: VIN varchar(50) DEFAULT NULL
 leaf_spy: DEVBAT int(11) DEFAULT NULL
 leaf_spy: GIDS int(11) DEFAULT NULL
 leaf_spy: LAT double DEFAULT NULL
 leaf_spy: LONG double DEFAULT NULL
 leaf_spy: ELV int(11) DEFAULT NULL
 leaf_spy: SEQ int(11) DEFAULT NULL
 leaf_spy: TRIP int(11) DEFAULT NULL
 leaf_spy: ODO int(11) DEFAULT NULL
 leaf_spy: SOC float DEFAULT NULL
 leaf_spy: AHR float DEFAULT NULL
 leaf_spy: BATTEMP float DEFAULT NULL
 leaf_spy: AMB float DEFAULT NULL
 leaf_spy: WPR int(11) DEFAULT NULL
 leaf_spy: PLUGSTATE tinyint(1) DEFAULT NULL
 leaf_spy: CHRGMODE tinyint(1) DEFAULT NULL
 leaf_spy: CHRGPWR int(11) DEFAULT NULL
 leaf_spy: PWRSW tinyint(1) DEFAULT NULL
 leaf_spy: TUNITS varchar(4) DEFAULT NULL
 leaf_spy: RPM int(11) DEFAULT NULL
 leaf_spy: SOH float DEFAULT NULL
 leaf_spy: HX float DEFAULT NULL
 leaf_spy: SPEED float DEFAULT NULL
 leaf_spy: BATVOLTS float DEFAULT NULL
 leaf_spy: BATAMPS float DEFAULT NULL
 leaf_spy: CREATEDON datetime DEFAULT current_timestamp()
 
 leaf_spy_cars: ID int(10) unsigned NOT NULL auto_increment
 leaf_spy_cars: VIN varchar(50) DEFAULT NULL
 leaf_spy_cars: DEVBAT int(11) DEFAULT NULL
 leaf_spy_cars: GIDS int(11) DEFAULT NULL
 leaf_spy_cars: LAT double DEFAULT NULL
 leaf_spy_cars: LONG double DEFAULT NULL
 leaf_spy_cars: ELV int(11) DEFAULT NULL
 leaf_spy_cars: SEQ int(11) DEFAULT NULL
 leaf_spy_cars: TRIP int(11) DEFAULT NULL
 leaf_spy_cars: ODO int(11) DEFAULT NULL
 leaf_spy_cars: SOC float DEFAULT NULL
 leaf_spy_cars: AHR float DEFAULT NULL
 leaf_spy_cars: BATTEMP float DEFAULT NULL
 leaf_spy_cars: AMB float DEFAULT NULL
 leaf_spy_cars: WPR int(11) DEFAULT NULL
 leaf_spy_cars: PLUGSTATE tinyint(1) DEFAULT NULL
 leaf_spy_cars: CHRGMODE tinyint(1) DEFAULT NULL
 leaf_spy_cars: CHRGPWR int(11) DEFAULT NULL
 leaf_spy_cars: PWRSW tinyint(1) DEFAULT NULL
 leaf_spy_cars: TUNITS varchar(4) DEFAULT NULL
 leaf_spy_cars: RPM int(11) DEFAULT NULL
 leaf_spy_cars: SOH float DEFAULT NULL
 leaf_spy_cars: HX float DEFAULT NULL
 leaf_spy_cars: SPEED float DEFAULT NULL
 leaf_spy_cars: BATVOLTS float DEFAULT NULL
 leaf_spy_cars: BATAMPS float DEFAULT NULL
 leaf_spy_cars: CREATEDON datetime DEFAULT current_timestamp()
 
 leaf_spy_properties: ID int(10) unsigned NOT NULL auto_increment
 leaf_spy_properties: CAR_ID int(11) DEFAULT NULL
 leaf_spy_properties: PROPERTY varchar(1000) DEFAULT NULL
 leaf_spy_properties: VALUE varchar(1000) DEFAULT NULL
 leaf_spy_properties: LINKED_OBJECT varchar(1000) DEFAULT NULL
 leaf_spy_properties: LINKED_PROPERTY varchar(1000) DEFAULT NULL
 leaf_spy_properties: LINKED_METHOD varchar(1000) DEFAULT NULL
 leaf_spy_properties: UPDATEDON datetime DEFAULT current_timestamp()
EOD;
  parent::dbInstall($data);
 }
// --------------------------------------------------------------------
}
/*
*
* TW9kdWxlIGNyZWF0ZWQgU2VwIDA2LCAyMDIzIHVzaW5nIFNlcmdlIEouIHdpemFyZCAoQWN0aXZlVW5pdCBJbmMgd3d3LmFjdGl2ZXVuaXQuY29tKQ==
*
*/
