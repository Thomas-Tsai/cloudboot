<?php
// Get utility functions and set globals
require_once "config.php";
require_once "functions.php";

$bootcfg = ( isset ( $_GET['boot'] ) ) ? $_GET['boot'] : "selectmode";
header ( "Content-type: text/plain" );

echo 'MENU COLOR UNSEL 7;32;41 #c0000090 #00000000'."\n\n";

## reference:http://web.archiveorange.com/archive/v/mwjwmJ0CIqkvn1V88yus
if ( $bootcfg == "selectmode" ) {
    echo "UI $pxe_vesamenu\n\n";
    
    echo "MENU TITLE $pxe_menu_title\n\n";
    echo "MENU BACKGROUND $pxe_background\n\n";

    foreach ( $menu as $proj_dist => $submenu ) {
	foreach ( $submenu as $proj ) {
	    $proj_menu = "$proj";
	    echo "LABEL $proj_menu\n";
	    echo "COM32 $pxe_vesamenu\n";
	    echo "APPEND http://$boot_url/$boot_path/$boot_menu_path?boot=$proj_menu\n\n";
	}
    }
    exit;
} 

if ( in_array ( $bootcfg, $all_menu ) ) {
    echo "MENU TITLE $bootcfg\n\n";
    if ( $bootcfg == "memtest" ){
	echo "MENU BACKGROUND $pxe_background\n\n";
	memtest_menu( $bootcfg );
    } elseif ( $bootcfg == "freedos" ){
	echo "MENU BACKGROUND $pxe_background\n\n";
	freedos_menu( $bootcfg );
    } else {
	echo "MENU BACKGROUND $background[$bootcfg]\n\n";
	KernelCloudMenu( $bootcfg );
	ISOCloudMenu( $bootcfg );
    }
}

#if ($enable_netinstall) {
#    echo "\nMENU BEGIN NETINSTALL\n\n";
#	$netinstall_page = file_get_contents($freeurl['netinstall']);
#	$page_ok = preg_match("/200/",$http_response_header[0]);
#	if ($page_ok){
#	    $img = get_iso_from_page($netinstall_page, $pattern['netinstall']);
#	}
#	foreach ($img as $file) {
#	    if (preg_match("/amd64/", $file)){
#		$arch = "x86_64 arch";	
#	    }else{
#		$arch = "x86 arch";
#	    }
#	    echo "label $file\n";
#	    echo "\tMENU LABEL $file\n";
#	    if (($enable_sourceforge == true) || ($mirror == "SF")){
#		echo "\tkernel $sfurl[netinstall]vmlinuz-netinstall-$file\n";
#		echo "\tappend initrd=$sfurl[netinstall]initrd-netinstall-$file.img ramdisk_size=128000\n";
#	    } elseif($mirror == "NCHC") {
#		echo "\tkernel $freeurl[netinstall]vmlinuz-netinstall-$file\n";
#		echo "\tappend initrd=$freeurl[netinstall]initrd-netinstall-$file.img ramdisk_size=128000\n";
#	    } else {
#		echo "\tkernel $freeurl[netinstall]vmlinuz-netinstall-$file\n";
#		echo "\tappend initrd=$freeurl[netinstall]initrd-netinstall-$file.img ramdisk_size=128000\n";
#	    }
#	    echo "\tTEXT HELP\n";
#	    echo "\tNetinstall $file for $arch\n";
#	    echo "\tENDTEXT\n";
#	}
#    echo "\nMENU END\n\n";
#}
#
#
#### end of main ###
#}
?>

