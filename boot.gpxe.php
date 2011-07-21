<?php
require "config.php";
header ( "Content-type: text/plain" );
$mirror = (isset($_GET['mirror']))?$_GET['mirror']:$default_mirror;
$mirror = strtoupper ($mirror); 
echo <<< GPXE
#!gpxe
imgfree
set 209:string $boot_menu_path?mirror=$mirror
set 210:string $local_url/
chain $local_url/$pxelinux_file
GPXE;
?>
