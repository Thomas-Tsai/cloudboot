<?php
require_once "config.php";
require_once "functions.php";
header ( "Content-type: text/plain" );
echo <<< IPXE
#!gpxe
imgfree
set 209:string $boot_menu_path
set 210:string http://$boot_url/$boot_path/
chain http://$boot_url/$boot_path/$pxelinux_file
IPXE;
?>
