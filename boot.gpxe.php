<?php
require "config.php";
header ( "Content-type: text/plain" );
echo <<< IPXE
#!gpxe
imgfree
set 209:string $boot_menu_path
set 210:string http://$local_url/$local_path/
chain http://$local_url/$local_path/$pxelinux_file
IPXE;
?>
