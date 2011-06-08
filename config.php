<?php

##important###################################
# please set rewrite rule to web service like:
# BOOTMENU  => BOOTMENU.php
# boot.gpxe => boot.gpxe.php
##############################################

### options
$enable_sourceforge = false;
$enable_netinstall = true;  # run 'drbl-netinstall -d xxx -i all'
$enable_custom_rom = true;

### global variable for kernel url
$site	    = "140.110.240.48";
$local_path = "cloudboot";
$local_url  = "http://$site/$local_path";
$kernel	    = "pxe/memdisk";  # kernel link for pxelinux
$boot_menu_path = "BOOTMENU"; # BOOTMENU.php rewrite to BOOTMENU, rewrite needed
$pxelinux_file = "pxe/pxelinux.0";
$kernel_url = "$local_url/$kernel";
$freedos_url = "$local_url/small_img/freedos.img";
$memtest_url = "$local_url/small_img/memtest";
$agent_url   = "$local_url/get_image.php";

### global variable for pxe menu
$pxe_vesamenu	= "pxe/vesamenu.c32";
$pxe_timeout	= "50";
$pxe_prompt	= "0";
$pxe_noescape	="0";
$pxe_background = "pxe/drblwp.png";
$pxe_menu_title ="MENU TITLE free.nchc.org.tw";

### global variable for project download link from sourceforge
$sfurl['clonezilla-stable']                  = "http://prdownloads.sourceforge.net/clonezilla/";
$sfurl['clonezilla-testing']                 = "http://prdownloads.sourceforge.net/clonezilla/";
$sfurl['clonezilla-alternative-stable']      = "http://prdownloads.sourceforge.net/clonezilla/";
$sfurl['clonezilla-alternative-testing']     = "http://prdownloads.sourceforge.net/clonezilla/";
$sfurl['drbl-stable']                        = "http://prdownloads.sourceforge.net/drbl/";
$sfurl['drbl-testing']                       = "http://prdownloads.sourceforge.net/drbl/";
$sfurl['drbl-unstable']                      = "http://prdownloads.sourceforge.net/gparted/";
$sfurl['gparted-stable']                     = "http://prdownloads.sourceforge.net/gparted/";
$sfurl['gparted-testing']                    = "http://prdownloads.sourceforge.net/gparted/";
$sfurl['freedos']			     = "$local_url/small_img/";
$sfurl['netinstall']		             = "$local_url/netinstall_img/";

### global variable for project download link from free
$freeurl['clonezilla-stable']                  = "http://free.nchc.org.tw/clonezilla-live/stable/";
$freeurl['clonezilla-testing']                 = "http://free.nchc.org.tw/clonezilla-live/testing/";
$freeurl['clonezilla-alternative-stable']      = "http://free.nchc.org.tw/clonezilla-live/alternative/stable/";
$freeurl['clonezilla-alternative-testing']     = "http://free.nchc.org.tw/clonezilla-live/alternative/testing/";
$freeurl['drbl-stable']                        = "http://free.nchc.org.tw/drbl-live/stable/";
$freeurl['drbl-testing']                       = "http://free.nchc.org.tw/drbl-live/testing/";
$freeurl['drbl-unstable']                      = "http://free.nchc.org.tw/drbl-live/unstable/";
$freeurl['gparted-stable']                     = "http://free.nchc.org.tw/gparted-live/stable/";
$freeurl['gparted-testing']                    = "http://free.nchc.org.tw/gparted-live/testing/";
$freeurl['freedos']		               = "$local_url/small_img/";
$freeurl['netinstall']		               = "$local_url/netinstall_img/";

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
$pattern['netinstall']			   = '/<a href.*initrd-netinstall-.*img.*>initrd-netinstall-(.*).img<\/a>/';

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
