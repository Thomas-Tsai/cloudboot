<?php
require "config.php";
global $boot_menu_path, $local_url, $pxelinux_file;
header ( "Content-type: text/plain" );
echo <<< GPXE
#!gpxe
set 209:string $boot_menu_path
set 210:string $local_url/
chain $local_url/$pxelinux_file
GPXE;
?>
