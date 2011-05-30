<?php

##important###################################
# please set rewrite rule to web service like:
# BOOTMENU  => BOOTMENU.php
# boot.gpxe => boot.gpxe.php
##############################################

### global variable for kernel url
$local_url  = "http://140.110.240.52/drbloncloud";
$kernel	    = "pxe/memdisk";  # kernel link for pxelinux
$boot_menu_path = "BOOTMENU";//BOOTMENU.php rewrite to BOOTMENU, rewrite needed
$pxelinux_file = "pxelinux.0";
$kernel_url = "$local_url/$kernel";
$freedos_url = "$local_url/small_img/freedos.img";
$memtest_url = "$local_url/small_img/memtest";
$agent_url   = "$local_url/get_image.php";

### global variable for pxe menu
$pxe_vesamenu	= "pxe/vesamenu.c32";
$pxe_timeout	= "70";
$pxe_prompt	= "0";
$pxe_noescape	="0";
$pxe_background = "pxe/drblwp.png";
$pxe_menu_title ="MENU TITLE free.nchc.org.tw";

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
$url['freedos']				   = "http://140.110.240.52/drbloncloud/small_img/";

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
$pattern['freedos']			   = '/<a href.*freedos.img.*>(.*)<\/a>/';

### menu layout
$menu['clonezilla']		= array('clonezilla-stable', 'clonezilla-testing');
$menu['clonezilla-alternative'] = array('clonezilla-alternative-stable', 'clonezilla-alternative-testing');
$menu['drbl']			= array('drbl-stable', 'drbl-testing', 'drbl-unstable');
$menu['gparted']		= array('gparted-stable', 'gparted-testing');
$default_proj = 'drbl-stable';
$default_arch = 'i686';

### debug and log 
$enable_debug	= true;
$enable_log	= true;
?>
