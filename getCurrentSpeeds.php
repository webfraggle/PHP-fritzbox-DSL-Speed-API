<?php
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL);
include "config.inc.php";

include "dataFunctions.inc.php";
include "fritzFunctions.inc.php";
header('Content-Type: application/json');
loadData();
checkSession();
// exit;

$url = $fritz_url."/internet/inetstat_monitor.lua?sid=".$data['SID']."&myXhr=1&action=get_graphic&useajax=1&xhr=1&t".rand(10000,99999)."=nocache";
$json = file_get_contents($url);
print $json;
saveData();
?>