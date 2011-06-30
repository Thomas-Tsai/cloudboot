<?php
require "config.php";
#echo var_dump($_GET);
global $freeurl, $sfurl, $enable_sourceforge;
$proj   = $_GET['proj'];
$file   = $_GET['file'];
$mirror = $_GET['mirror'];

if (($enable_sourceforge == true) && ($mirror == "SF")){
    $isourl="$sfurl[$proj]$file";
}elseif($mirror == "NCHC"){
    $isourl="$freeurl[$proj]$file";
}else{
    $isourl="$freeurl[$proj]$file";
}
header( "Location: $isourl");
?>
