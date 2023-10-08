<?php
/*
* @version 0.1
*/
global $session;

if ($this->owner->name=='panel') {
   $out['CONTROLPANEL']=1;
}
$filter="1";

global $save_qry;
if ($save_qry) {
   $filter = $session->data['leaf_spy_qry'];
} else {
   $session->data['leaf_spy_qry'] = $filter;
}
if (!$filter) $filter="1";

$sortby_leaf_spy="ID DESC";
$query_text = "SELECT `ID`, `DEVBAT`, `LAT`, `LONG`, `ELV`, `TRIP`, `ODO`, `SOC`, `BATTEMP`, `RPM`, `SOH`, ROUND(`SPEED`*3.6, 1) AS `SPEED`, `BATVOLTS`, `BATAMPS`, `CREATEDON`,
            `AHR`, `GIDS`, `HX`, `TUNITS` FROM leaf_spy WHERE $filter ORDER BY ".$sortby_leaf_spy;
$out['SORTBY']=$sortby_leaf_spy;

// SEARCH RESULTS
$res=SQLSelect($query_text);
if ($res[0]['ID']) {
   paging($res, 50, $out); // search result paging
   $total=count($res);
   for($i=0;$i<$total;$i++) {
      // some action for every record if required
   }
   $out['RESULT']=$res;
}
