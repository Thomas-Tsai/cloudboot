<?php
require "config.php";
global $boot_menu_path, $local_url, $boot_pxe_path;
header ( "Content-type: text/plain" );
echo <<< GPXE
#!gpxe
set 209:string $boot_menu_path
set 210:string $local_url/
chain \${210:string}/pxe/$pxelinux_file
GPXE;
?>
