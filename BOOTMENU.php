<?php
// Get utility functions and set globals
require_once "config.php";
require_once "functions.php";

$bootcfg = ( isset( $_GET['boot'] ) ) ? $_GET['boot'] : "selectmode";
header ( "Content-type: text/plain" );

if ($bootcfg == "selectmode"){
    echo "UI pxe/vesamenu.c32\n\n";

    foreach ($menu as $proj_dist => $submenu){
	foreach($submenu as $proj){
	    $proj_menu = "$proj_dist-$proj";
	    echo "LABEL $proj_menu Cloud\n";
	    echo "COM32 $pxe_vesamenu\n";
	    echo "APPEND http://cloudboot.nchc.org.tw/cloudboot/BOOTMENU.php?boot=$proj_menu\n";
	}
    }
    exit;
} 

if ( $bootcfg != "" ){
        
}

#elseif ( $bootcfg == "drbl-stable"){
#    echo "MENU BEGIN CloudKernel from Local\n";
#    echo "	label drbl-live-stable-486 from local
#    echo "	MENU LABEL drbl-live-stable-486
#    echo "	kernel http://sars-048.nchc.org.tw/cloudboot/local_image/drbl-live/stable/drbl-live-xfce-1.0.5-6-i486/live/vmlinuz\n";
#    echo "	append initrd=http://sars-048.nchc.org.tw/cloudboot/local_image/drbl-live/stable/drbl-live-xfce-1.0.5-6-i486/live/initrd.img boot=live config nomodeset noprompt vga=785 nosplash ip="eth0:140.110.240.46:255.255.255.0:140.110.240.254" fetch=http://sars-048.nchc.org.tw/cloudboot/local_image/drbl-live/stable/drbl-live-xfce-1.0.5-6-i486/live/filesystem.squashfs\n";
#    echo "MENUEND\n";
#    echo "MENU BEGIN CloudKernel from NCHC Taiwan\n";
#    echo "MENUEND\n";
#    echo "MENU BEGIN CloudKernel from SourceForge\n";
#    echo "MENUEND\n";
#    echo "MENU BEGIN FULL ISO from Local\n";
#    echo "MENUEND\n";
#    echo "MENU BEGIN FULL ISO from NCHC Taiwan\n";
#    echo "MENUEND\n";
#    echo "MENU BEGIN FULL ISO from SourceForge\n";
#    echo "MENUEND\n";
#} elseif ( $bootcfg == "drbl-testing"){
#} elseif ( $bootcfg == "drbl-unstable"){
#} elseif ( $bootcfg == "clonezilla-stable"){
#} elseif ( $bootcfg == "clonezilla-testing"){
#} elseif ( $bootcfg == "clonezilla-alternative-stable"){
#} elseif ( $bootcfg == "clonezilla-alternativ-testing"){
#} elseif ( $bootcfg == "gparted-stable"){
#} elseif ( $bootcfg == "gparted-testing"){
#} else {
#    echo "label freedos\n";
#    echo "    MENU LABEL freedos\n";
#    echo "    kernel $kernel_url\n";
#    echo "    initrd $freedos_url\n";
#    echo "\n";
#    echo "label memtest\n";
#    echo "    MENU LABEL memtest\n";
#    echo "    kernel $memtest_url\n";
#}
#echo <<< KERNELMENU
#MENU BEGIN DRBL
#    MENU BEGIN stable
#        MENU BEGIN 486
#            label drbl-live-stable-486
#            MENU LABEL drbl-live-stable-486
#            kernel http://sars-048.nchc.org.tw/cloudboot/local_image/drbl-live/stable/drbl-live-xfce-1.0.5-6-i486/live/vmlinuz
#
#            append initrd=http://sars-048.nchc.org.tw/cloudboot/local_image/drbl-live/stable/drbl-live-xfce-1.0.5-6-i486/live/initrd.img boot=live config nomodeset noprompt vga=785 nosplash ip="eth0:140.110.240.46:255.255.255.0:140.110.240.254" fetch=http://sars-048.nchc.org.tw/cloudboot/local_image/drbl-live/stable/drbl-live-xfce-1.0.5-6-i486/live/filesystem.squashfs
#        MENUEND
#    MENUEND
#MENUEND
#KERNELMENU;
#} elseif ( $bootcfg == "ISO"){
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

