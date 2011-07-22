<?php
require "config.php";
header ( "Content-type: text/plain" );
echo <<< IPXE
#!gpxe
imgfree
set 209:string $boot_menu_path
set 210:string $local_url/
chain $local_url/$pxelinux_file
IPXE;
?>
