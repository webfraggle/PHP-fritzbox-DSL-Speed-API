<?php
error_reporting(E_ALL);
include "config.inc.php";
include "dataFunctions.inc.php";
include "fritzFunctions.inc.php";
loadData();
checkSession();

header('Content-type: image/svg+xml');
$url = $fritz_url."/internet/inetstat_monitor.lua?sid=".$data['SID']."&myXhr=1&action=get_graphic&useajax=1&xhr=1&t".rand(10000,99999)."=nocache";
$json = file_get_contents($url);
$t = json_decode($json,true);

$angles = [270,300,330,0,30,60,90,120,150,180,210,240];
$numbers = [];
for ($i=0; $i < count($angles); $i++) { 
    $numbers[] = ((int)$t[0]['ds_bps_curr'][$i]/(int)$t[0]['ds_bps_max']);
}
// $numbers = [0.5,0.5,1,1,1,0,1,1,1,1,1,1];
$centerX = 100;
$centerY = 100;
$path = "";
foreach ($numbers as $i => $v) {
    $angle = $angles[$i];
    $radius = 30+(70*$v);
    $x = $centerX + $radius * cos(deg2rad($angle));
    $y = $centerY + $radius * sin(deg2rad($angle));
    $path .= ($i == 0) ? "M" : "L";
    $path .= sprintf('%.6f', $x).",".sprintf('%.6f', $y);

}

// exit;
?>

<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
 <g>
  <title>Layer 1</title>
  <path id="svg_2" d="
  <?php
  print $path;
  ?>
  " opacity="1" fill="#fff"/>
  <ellipse ry="30" rx="30" id="svg_1" cy="100" cx="100" fill="#121212"/>
 </g>
</svg>

<?php
saveData();
?>