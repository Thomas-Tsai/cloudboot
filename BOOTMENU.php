<?php
// Get utility functions and set globals
require_once "config.php";
require_once "functions.php";

$bootcfg = ( isset ( $_GET['boot'] ) ) ? $_GET['boot'] : "selectmode";
header ( "Content-type: text/plain" );

## reference:http://web.archiveorange.com/archive/v/mwjwmJ0CIqkvn1V88yus
if ( $bootcfg == "selectmode" ) {
    echo "UI $pxe_vesamenu\n\n";

    foreach ( $menu as $proj_dist => $submenu ) {
	foreach ( $submenu as $proj ) {
	    $proj_menu = "$proj";
	    echo "LABEL $proj_menu Cloud\n";
	    echo "COM32 $pxe_vesamenu\n";
	    echo "APPEND http://$local_url/$local_path/$boot_menu_path?boot=$proj_menu\n\n";
	}
    }
    exit;
} 

if ( in_array ( $bootcfg, $all_menu ) ) {
    KernelCloudMenu( $bootcfg );
    ISOCloudMenu( $bootcfg );
#    echo "label clonezilla-stable\n";
#    echo "menu label clonezilla-stable clonezilla-live-1.2.8-46-i686\n";
#    echo "kernel http://cloudboot.nchc.org.tw/cloudboot/get_image.php?mirror=local&type=kernel&proj=clonezilla-stable&file=clonezilla-live-1.2.8-46-i686.vmlinuz\n";
#    echo 'append initrd=http://cloudboot.nchc.org.tw/cloudboot/get_image.php?mirror=local&type=kernel&proj=clonezilla-stable&file=clonezilla-live-1.2.8-46-i686.initrd.img fetch=http://cloudboot.nchc.org.tw/cloudboot/kernel_img/clonezilla-live-1.2.8-46-i686.filesystem.squashfs ip=frommedia debug boot=live config  noswap nolocales edd=on nomodeset noprompt ocs_live_run="ocs-live-general" ocs_live_extra_param="" ocs_live_keymap="NONE" ocs_live_batch="no" ocs_lang="zh_TW.UTF-8" vga=788 nosplash';

}

#
#print_menu_head();
###
#### main ###
#
#print_default_menu_entry();
#
#### get download page and convert to pxelinux menu style ###
#foreach ($menu as $proj_dist => $submenu){
#    echo "\nMENU BEGIN $proj_dist\n\n";
#    foreach($submenu as $proj){
#	$page = file_get_contents($freeurl[$proj]);
#	$page_ok = preg_match("/200/",$http_response_header[0]);
#	//echo "$link-$http_response_header[0]\n";
#	if ($page_ok){
#	    $iso = get_iso_from_page($page, $pattern[$proj]);
#	}
#	foreach ($iso as $file) {
#	    if (preg_match("/amd64/", $file)){
#		$arch = "x86_64 arch";	
#	    }else{
#		$arch = "x86 arch";
#	    }
#	    echo "label $file\n";
#	    echo "\tMENU LABEL $file\n";
#	    echo "\tkernel $kernel_url\n";
#	    echo "\tinitrd $agent_url?proj=$proj&file=$file&mirror=$mirror\n";
#	    echo "\tappend iso raw\n";
#	    echo "\tTEXT HELP\n";
#	    echo "\tBooting to $proj for $arch\n";
#	    echo "\tENDTEXT\n";
#	}
#    }
#    echo "\nMENU END\n\n";
#}
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

