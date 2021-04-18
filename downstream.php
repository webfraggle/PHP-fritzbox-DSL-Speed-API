<?php
include "includes.inc.php";


$url = $fritz_url."/internet/inetstat_monitor.lua?sid=".$data['SID']."&myXhr=1&action=get_graphic&useajax=1&xhr=1&t".rand(10000,99999)."=nocache";
$jsonString = file_get_contents($url);
$t = json_decode($jsonString,true);
// print ((int)$t[0]['ds_bps_curr'][0]."/".(int)$t[0]['ds_bps_max']);
$a = ((int)$t[0]['ds_bps_curr'][0]/(int)$t[0]['ds_bps_max']);
// print_r($t);
echo sprintf('%.6f', $a);

saveData();
?>