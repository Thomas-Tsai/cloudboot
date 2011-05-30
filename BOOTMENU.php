<?php
### TODO ###
#1. SSL support?
#2. change background.png
#3. 
### set page to text mode ###
header ( "Content-type: text/plain" );

### print pxe menu, copy from pxelinux.cfg/default ###
function print_menu_head(){
    $vesamenu = "vesamenu.c32";
    $timeout = "70";
    $prompt= "0";
    $noescape ="1";
    $background = "drblwp.png";
    echo <<< END
default $vesamenu
timeout $timeout
prompt $prompt
noescape $noescape
MENU MARGIN 5
MENU BACKGROUND $background
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


### main ###
$kernel = "http://140.110.240.52/drbloncloud/memdisk";  # kernel link for pxelinux

### global variable for project download link
$url['clonezilla-stable']                  = "http://free.nchc.org.tw/clonezilla-live/stable/";
$url['clonezilla-testing']                 = "http://free.nchc.org.tw/clonezilla-live/testing/";
$url['clonezilla-alternative-stable']      = "http://free.nchc.org.tw/clonezilla-live/alternative/stable/";
$url['clonezilla-alternative-testing']     = "http://free.nchc.org.tw/clonezilla-live/alternative/testing/";
$url['drbl-stable']                        = "http://free.nchc.org.tw/drbl-live/stable/";
$url['drbl-testing']                       = "http://free.nchc.org.tw/drbl-live/testing/";
$url['drbl-unstable']                      = "http://free.nchc.org.tw/drbl-live/unstable/";
$url['gparted-stable']                     = "http://free.nchc.org.tw/gparted-live/stable/";
$url['gparted-testing']                    = "http://free.nchc.org.tw/gparted-live/testing/";

### global variable for project pattern which defined regular expression for iso link
$pattern['clonezilla-stable']              = '/<a href.*clonezilla.*iso.*>(.*)<\/a>/';
$pattern['clonezilla-testing']             = $pattern['clonezilla-stable'];
$pattern['clonezilla-alternative-stable']  = $pattern['clonezilla-stable'];
$pattern['clonezilla-alternative-testing'] = $pattern['clonezilla-stable'];
$pattern['drbl-stable']                    = '/<a href.*drbl.*iso.*>(.*)<\/a>/';
$pattern['drbl-testing']                   = $pattern['drbl-stable']; 
$pattern['drbl-unstable']                  = $pattern['drbl-stable'];
$pattern['gparted-stable']                 = '/<a href.*gparted.*iso.*>(.*)<\/a>/';
$pattern['gparted-testing']                = $pattern['gparted-stable'];

print_menu_head();

### get download page and convert to pxelinux menu style ###
foreach ($url as $proj => $link){
    $page = file_get_contents($link);
    $page_ok = preg_match("/200/",$http_response_header[0]);
    //echo "$link-$http_response_header[0]\n";
    if ($page_ok){
	$iso = get_iso_from_page($page, $pattern[$proj]);
    }
    foreach ($iso as $version) {
	#label http-clonezilla-iso
	#    MENU LABEL http clonezilla iso
	#    kernel http://140.110.240.52/gpxe/memdisk 
	#    initrd http://140.110.240.52/gpxe/clonezilla-live-1.2.8-23-i686.iso
	#    append iso raw  
	#echo "$version<br>\n";
	echo "label $proj-$version\n";
	echo "\tMENU LABEL $proj-$version\n";
	echo "\tkernel $kernel\n";
	echo "\tinitrd $link$version\n";
	echo "\tappend iso raw\n";
	echo "\n";
    }
}

### end of main ###
?>

