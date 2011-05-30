<?php
require "config.php";
$proj = $_GET['proj'];
$file = $_GET['file'];
$isourl="$url[$proj]/$file";
header( "Location: $isourl");
?>
