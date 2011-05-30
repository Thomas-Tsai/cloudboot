<?php
require "config.php";
global $freeurl, $sfurl, $enable_sourceforge;
$proj = $_GET['proj'];
$file = $_GET['file'];
if ($enable_sourceforge == true){
    $isourl="$sfurl[$proj]$file";
}else{
    $isourl="$freeurl[$proj]$file";
}

header( "Location: $isourl");
?>
