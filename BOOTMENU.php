<?php
// Get utility functions and set globals
require "config.php";
$mirror = $_GET['mirror'];
header ( "Content-type: text/plain" );

##
if (($enable_sourceforge == true) && ($mirror == "SF")) {
    $kernel_url  = "$sfurl[$kernel]$kernel";
    $freedos_url = "$sfurl[$freedos]$freedos";
    $memtest_url = "$sfurl[$memtest]$memtest";
} elseif($mirror == "NCHC") {
    $kernel_url  = "$freeurl[$kernel]$kernel";
    $freedos_url = "$freeurl[$freedos]$freedos";
    $memtest_url = "$freeurl[$memtest]$memtest";
} else {
    $kernel_url  = "$freeurl[$kernel]$kernel";
    $freedos_url = "$freeurl[$freedos]$freedos";
    $memtest_url = "$freeurl[$memtest]$memtest";
}

### print pxe menu, copy from pxelinux.cfg/default ###
function print_menu_head(){
    global $pxe_vesamenu;
    global $pxe_timeout;
    global $pxe_prompt;
    global $pxe_noescape;
    global $pxe_background;
    global $pxe_menu_title;

    echo <<< END
default $pxe_vesamenu
timeout $pxe_timeout
prompt $pxe_prompt
noescape $pxe_noescape
MENU MARGIN 5
MENU BACKGROUND $pxe_background
MENU COLOR UNSEL 7;32;41 #c0000090 #00000000
MENU COLOR TIMEOUT_MSG 7;32;41 #c0000090 #00000000
MENU COLOR TIMEOUT 7;32;41 #c0000090 #00000000
MENU COLOR HELP 7;32;41 #c0000090 #00000000

say **********************************************
say Welcome to DRBL.
say NCHC Free Software Labs, Taiwan.
say http://drbl.nchc.org.tw; http://drbl.sf.net
say **********************************************

ALLOWOPTIONS 1

END;
# simple menu title
echo $pxe_menu_title."\n";
}

### function to find iso name and link ###
function get_iso_from_page($page, $regx){
    if (($page == '') || ($regx == '')){
	return;
    }
    $proj_iso = array();
    if (preg_match_all($regx, $page, $match, PREG_SET_ORDER)){
	for ($i = 0; $i < sizeof($match); $i++){
	    array_push($proj_iso, $match[$i][1]);
	}
    } else {
	#echo "can't find iso\n";
    }
    return $proj_iso;
}

function print_default_menu_entry(){
    global $agent_url, $kernel_url, $freeurl, $pattern, $default_proj, $default_arch, $mirror;
    $page = file_get_contents($freeurl[$default_proj]);
    $page_ok = preg_match("/200/",$http_response_header[0]);
    //echo "$link-$http_response_header[0]\n";

    if ($page_ok){
	$iso = get_iso_from_page($page, $pattern[$default_proj]);
    } else {
	return;	
    }

    $def_entry=$iso[0];
    if (sizeof($iso)>1){
	foreach ($iso as $file) {
	    if (preg_match("/686/", $file)){
		$def_entry = $file;
	    } elseif(preg_match("/86/", $file)) {
		$def_entry = $file;
	    }
	}
	if ($def_entry == ""){
	    $def_entry=$iso[0];    
	}
    } else {
	$def_entry=$iso[0];
    }

    if (preg_match("/amd64/", $def_entry)){
	$arch = "x86_64 arch";	
    }else{
	$arch = "x86 arch";
    }
    echo "label $def_entry\n";
    echo "\tMENU LABEL $def_entry\n";
    echo "\tMENU DEFAULT\n";
    echo "\tkernel $kernel_url\n";
    echo "\tinitrd $agent_url?proj=$default_proj&file=$def_entry&mirror=$mirror\n";
    echo "\tappend iso raw\n";
    echo "\tTEXT HELP\n";
    echo "\tBooting to $default_proj for $arch\n";
    echo "\tENDTEXT\n";
}

### main ###

print_menu_head();
print_default_menu_entry();

### get download page and convert to pxelinux menu style ###
foreach ($menu as $proj_dist => $submenu){
    global $mirror;
    echo "\nMENU BEGIN $proj_dist\n\n";
    foreach($submenu as $proj){
	$page = file_get_contents($freeurl[$proj]);
	$page_ok = preg_match("/200/",$http_response_header[0]);
	//echo "$link-$http_response_header[0]\n";
	if ($page_ok){
	    $iso = get_iso_from_page($page, $pattern[$proj]);
	}
	foreach ($iso as $file) {
	    if (preg_match("/amd64/", $file)){
		$arch = "x86_64 arch";	
	    }else{
		$arch = "x86 arch";
	    }
	    echo "label $file\n";
	    echo "\tMENU LABEL $file\n";
	    echo "\tkernel $kernel_url\n";
	    echo "\tinitrd $agent_url?proj=$proj&file=$file&mirror=$mirror\n";
	    echo "\tappend iso raw\n";
	    echo "\tTEXT HELP\n";
	    echo "\tBooting to $proj for $arch\n";
	    echo "\tENDTEXT\n";
	}
    }
    echo "\nMENU END\n\n";
}
if ($enable_netinstall) {
    echo "\nMENU BEGIN NETINSTALL\n\n";
	$netinstall_page = file_get_contents($freeurl['netinstall']);
	$page_ok = preg_match("/200/",$http_response_header[0]);
	if ($page_ok){
	    $img = get_iso_from_page($netinstall_page, $pattern['netinstall']);
	}
	foreach ($img as $file) {
	    if (preg_match("/amd64/", $file)){
		$arch = "x86_64 arch";	
	    }else{
		$arch = "x86 arch";
	    }
	    echo "label $file\n";
	    echo "\tMENU LABEL $file\n";
	    if (($enable_sourceforge == true) || ($mirror == "SF")){
		echo "\tkernel $sfurl[netinstall]vmlinuz-netinstall-$file\n";
		echo "\tappend initrd=$sfurl[netinstall]initrd-netinstall-$file.img ramdisk_size=128000\n";
	    } elseif($mirror == "NCHC") {
		echo "\tkernel $freeurl[netinstall]vmlinuz-netinstall-$file\n";
		echo "\tappend initrd=$freeurl[netinstall]initrd-netinstall-$file.img ramdisk_size=128000\n";
	    } else {
		echo "\tkernel $freeurl[netinstall]vmlinuz-netinstall-$file\n";
		echo "\tappend initrd=$freeurl[netinstall]initrd-netinstall-$file.img ramdisk_size=128000\n";
	    }
	    echo "\tTEXT HELP\n";
	    echo "\tNetinstall $file for $arch\n";
	    echo "\tENDTEXT\n";
	}
    echo "\nMENU END\n\n";
}


echo "label freedos\n";
echo "    MENU LABEL freedos\n";
echo "    kernel $kernel_url\n";
echo "    initrd $freedos_url\n";
echo "\n";
echo "label memtest\n";
echo "    MENU LABEL memtest\n";
echo "    kernel $memtest_url\n";
echo "\n";
### end of main ###
?>

