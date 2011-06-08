<?php
require "config.php";
global $freeurl, $sfurl, $enable_sourceforge;
$manual_sf = 0;
$proj = $_GET['proj'];
$file = $_GET['file'];
$manual_sf = $_GET['sf'];
if (($enable_sourceforge == true) || ($manual_sf == 1)){
    $isourl="$sfurl[$proj]$file";
}else{
    $isourl="$freeurl[$proj]$file";
}

header( "Location: $isourl");
?>
