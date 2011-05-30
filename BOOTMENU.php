<?php
// Get utility functions and set globals
require "config.php";
header ( "Content-type: text/plain" );

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
    global $agent_url, $kernel_url, $freeurl, $pattern, $default_proj, $default_arch;
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
    echo "\tinitrd $agent_url?proj=$default_proj&file=$def_entry\n";
    echo "\tappend iso raw\n";
    echo "\tTEXT HELP\n";
    echo "\tBooting to $default_proj for $arch\n";
    echo "\tENDTEXT\n";
}

### main ###
global $kernel_url, $freeurl, $pattern, $menu, $freedos_url, $memtest_url, $default_proj, $default_arch;
print_menu_head();
print_default_menu_entry();

### get download page and convert to pxelinux menu style ###
foreach ($menu as $proj_dist => $submenu){

    echo "\nMENU BEGIN $proj_dist\n\n";
    foreach($submenu as $proj){
	$page = file_get_contents($freeurl[$proj]);
	$page_ok = preg_match("/200/",$http_response_header[0]);
	//echo "$link-$http_response_header[0]\n";
	if ($page_ok){
	    $iso = get_iso_from_page($page, $pattern[$proj]);
	}
	foreach ($iso as $file) {
	    //label http-clonezilla-iso
	    //    MENU LABEL http clonezilla iso
	    //    kernel http://140.110.240.52/gpxe/memdisk 
	    //    initrd http://140.110.240.52/gpxe/clonezilla-live-1.2.8-23-i686.iso
	    //    append iso raw  
	    //echo "$version<br>\n";
	    if (preg_match("/amd64/", $file)){
		$arch = "x86_64 arch";	
	    }else{
		$arch = "x86 arch";
	    }
	    echo "label $file\n";
	    echo "\tMENU LABEL $file\n";
	    echo "\tkernel $kernel_url\n";
	    echo "\tinitrd $agent_url?proj=$proj&file=$file\n";
	    echo "\tappend iso raw\n";
	    echo "\tTEXT HELP\n";
	    echo "\tBooting to $proj for $arch\n";
	    echo "\tENDTEXT\n";
	}
    }
    echo "\nMENU END\n\n";
}
echo <<<OTHERMENU
label freedos
    MENU LABEL freedos
    kernel $kernel_url
    initrd $freedos_url

label memtest
    MENU LABEL memtest
    kernel $memtest_url

OTHERMENU;
### end of main ###
?>

