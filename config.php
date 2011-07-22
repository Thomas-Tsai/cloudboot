<?php
require_once "functions.php";
$conf = read_option();
### global variable for menu script
$local_url	= $conf["local_url"];
$local_path	= $conf["local_path"];
$nchc_url	= $conf["nchc_url"];
$nchc_path	= $conf["nchc_path"];
$sf_url		= $conf["sf_url"];
$sf_path	= $conf["sf_path"];
$boot_menu_path	= $conf["boot_menu"];
$pxelinux_file	= $conf["pxelinux"];
$pxe_vesamenu	= $conf["pxe_vesamenu"];
$pxe_timeout	= $conf["pxe_timeout"];
$pxe_prompt	= $conf["pxe_prompt"];
$pxe_noescape	= $conf["pxe_noescape"];
$pxe_background	= $conf["pxe_background"];
$pxe_menu_title	= $conf["pxe_menu_title"];
$default_proj	= "$conf[default_proj]-$conf[default_version]";
$default_arch	= $conf["default_arch"];
$enable_sf	= $conf["enable_sourceforge"];
$default_mirror = $conf["default_repository"];

$local_uri	= "http://$local_url/$local_path";
$nchc_uri	= "http://$nchc_url/$nchc_path"
$sf_uri		= "http://$sf_url/$sf_path"

$memdisk	= "memdisk";
$freedos	= "freedos.img";
$memtest	= "memtest";
$agent_url	= "$local_url/get_image.php";


### global variable for project download link from sourceforge
$sfurl['clonezilla-stable']                    = "http://prdownloads.sourceforge.net/clonezilla/";
$sfurl['clonezilla-testing']                   = "http://prdownloads.sourceforge.net/clonezilla/";
$sfurl['clonezilla-alternative-stable']        = "http://prdownloads.sourceforge.net/clonezilla/";
$sfurl['clonezilla-alternative-testing']       = "http://prdownloads.sourceforge.net/clonezilla/";
$sfurl['drbl-stable']                          = "http://prdownloads.sourceforge.net/drbl/";
$sfurl['drbl-testing']                         = "http://prdownloads.sourceforge.net/drbl/";
$sfurl['drbl-unstable']                        = "http://prdownloads.sourceforge.net/gparted/";
$sfurl['gparted-stable']                       = "http://prdownloads.sourceforge.net/gparted/";
$sfurl['gparted-testing']                      = "http://prdownloads.sourceforge.net/gparted/";
$sfurl['freedos.img']			       = "http://prdownloads.sourceforge.net/cloudboot/";
$sfurl['memtest']			       = "http://prdownloads.sourceforge.net/cloudboot/";
$sfurl['memdisk']			       = "http://prdownloads.sourceforge.net/cloudboot/";
$sfurl['netinstall']		               = "http://prdownloads.sourceforge.net/cloudboot/";
$sfurl['kernel']		               = "http://prdownloads.sourceforge.net/cloudboot/";

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
$freeurl['freedos.img']		               = "http://free.nchc.org.tw/cloudboot/small_img/";
$freeurl['memtest']		               = "http://free.nchc.org.tw/cloudboot/small_img/";
$freeurl['memdisk']		               = "http://free.nchc.org.tw/cloudboot/small_img/";
$freeurl['netinstall']		               = "http://free.nchc.org.tw/cloudboot/netinstall_img/";
$freeurl['kernel']		               = "http://free.nchc.org.tw/cloudboot/kernel_img/";

### global variable for project download link from local mirror (you need mirror some files from sourceforge)
$localurl['clonezilla-stable']                 = "$local_url/local_img/clonezilla-live/stable/";
$localurl['clonezilla-testing']                = "$local_url/local_img/clonezilla-live/testing/";
$localurl['clonezilla-alternative-stable']     = "$local_url/local_img/clonezilla-live/alternative/stable/";
$localurl['clonezilla-alternative-testing']    = "$local_url/local_img/clonezilla-live/alternative/testing/";
$localurl['drbl-stable']                       = "$local_url/local_img/drbl-live/stable/";
$localurl['drbl-testing']                      = "$local_url/local_img/drbl-live/testing/";
$localurl['drbl-unstable']                     = "$local_url/local_img/drbl-live/unstable/";
$localurl['gparted-stable']                    = "$local_url/local_img/gparted-live/stable/";
$localurl['gparted-testing']                   = "$local_url/local_img/gparted-live/testing/";
$localurl['freedos.img']		       = "$local_url/small_img/";
$localurl['memtest']		               = "$local_url/small_img/";
$localurl['memdisk']		               = "$local_url/small_img/";
$localurl['netinstall']		               = "$local_url/netinstall_img/";
$localurl['kernel']			       = "$local_url/kernel_img/";

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
$pattern['netinstall']			   = '/<a href.*initrd-netinstall-.*img.*>initrd-netinstall-(.*).img<\/a>/';

### menu layout
$menu['clonezilla']		= array('clonezilla-stable', 'clonezilla-testing');
$menu['clonezilla-alternative'] = array('clonezilla-alternative-stable', 'clonezilla-alternative-testing');
$menu['drbl']			= array('drbl-stable', 'drbl-testing', 'drbl-unstable');
$menu['gparted']		= array('gparted-stable', 'gparted-testing');
$menu['other']			= array('other');
$all_menu = array_merge( $menu['clonezilla'], $menu['clonezilla-alternative'], $menu['drbl'], $menu['gparted'], $menu['other']);
?>
