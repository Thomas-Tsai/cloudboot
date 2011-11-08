<?php
require_once "functions.php";
$conf = read_option();
### global variable for menu script
$local_url	= $conf["repo_local_url"];
$local_path	= $conf["repo_local_path"];
$boot_menu_path	= $conf["boot_menu"];
$pxelinux_file	= $conf["pxelinux"];
$pxe_vesamenu	= $conf["pxe_vesamenu"];
$pxe_timeout	= $conf["pxe_timeout"];
$pxe_prompt	= $conf["pxe_prompt"];
$pxe_noescape	= $conf["pxe_noescape"];
$pxe_background	= $conf["pxe_background"];
$ocs_background = $conf["ocs_background"];
$drbl_background = $conf["drbl_background"];
$gparted_background = $conf["gparted_background"];
$pxe_menu_title	= $conf["pxe_menu_title"];
$default_proj	= "$conf[default_proj]-$conf[default_version]";
$default_arch	= $conf["default_arch"];
$default_mirror = $conf["default_repository"];

eval( "\$urlp = \"repo_$default_mirror\".\"_url\";" );
eval( "\$pathp = \"repo_$default_mirror\".\"_path\";" );
$urlp = strtolower($urlp);
$pathp = strtolower($pathp);
$boot_url	    = $conf[$urlp];
$boot_path	    = $conf[$pathp];

$memdisk	= "memdisk";
$freedos	= "freedos.img";
$memtest	= "memtest";
$ramdisk	= "128000";
$agent_url	= "$local_url/$local_path/get_image.php";
$memdisk_url	= "/small_img/$memdisk";
$supported_repo = explode( " " , $conf["supported_repo"] );
$repo = repo_info ( $supported_repo  );
$prefix_name = array();;
$kernel_param['clonezilla-stable'] = "boot=live config  noswap nolocales edd=on nomodeset noprompt ocs_live_run=\"ocs-live-general\" ocs_live_extra_param=\"\" ocs_live_keymap=\"\" ocs_live_batch=\"no\" ocs_lang=\"\" vga=788 nosplash";
$kernel_param['clonezilla-testing'] = $kernel_param['clonezilla-stable'];
$kernel_param['clonezilla-alternative-stable'] = $kernel_param['clonezilla-stable'];
$kernel_param['clonezilla-alternative-testing'] = $kernel_param['clonezilla-stable'];

$kernel_param['drbl-stable'] = "boot=live config nomodeset vga=785 ip=frommedia  nosplash";
$kernel_param['drbl-testing'] = $kernel_param['drbl-stable'];
#$kernel_param['drbl-unstable'] = $kernel_param['drbl-stable'];

$kernel_param['gparted-stable'] = "boot=live config  noswap noprompt  ip=frommedia  nosplash";
$kernel_param['gparted-testing'] = $kernel_param['gparted-stable'];

$background['gparted-stable'] = $background['gparted-testing'] = $conf["gparted_background"];
$background['drbl-stable'] = $background['drbl-testing'] = $conf["drbl_background"];
$background['clonezilla-stable'] = $background['clonezilla-testing'] = $conf["ocs_background"];
$background['clonezilla-alternative-stable'] = $background['clonezilla-alternative-testing'] = $conf["ocs_background"];

### global variable for project download link from sourceforge
$sf['clonezilla-stable']                    = "http://prdownloads.sourceforge.net/clonezilla/";
$sf['clonezilla-testing']                   = "http://prdownloads.sourceforge.net/clonezilla/";
$sf['clonezilla-alternative-stable']        = "http://prdownloads.sourceforge.net/clonezilla/";
$sf['clonezilla-alternative-testing']       = "http://prdownloads.sourceforge.net/clonezilla/";
$sf['drbl-stable']                          = "http://prdownloads.sourceforge.net/drbl/";
$sf['drbl-testing']                         = "http://prdownloads.sourceforge.net/drbl/";
#$sf['drbl-unstable']                        = "http://prdownloads.sourceforge.net/gparted/";
$sf['gparted-stable']                       = "http://prdownloads.sourceforge.net/gparted/";
$sf['gparted-testing']                      = "http://prdownloads.sourceforge.net/gparted/";
$sf['freedos']			       = "http://prdownloads.sourceforge.net/cloudboot/";
$sf['memtest']			       = "http://prdownloads.sourceforge.net/cloudboot/";
$sf['memdisk']			       = "http://prdownloads.sourceforge.net/cloudboot/";
$sf['netinstall']		               = "http://prdownloads.sourceforge.net/cloudboot/";
$sf['kernel']		               = "http://prdownloads.sourceforge.net/cloudboot/";

### global variable for project download link from free
$nchc['clonezilla-stable']                  = "http://free.nchc.org.tw/clonezilla-live/stable/";
$nchc['clonezilla-testing']                 = "http://free.nchc.org.tw/clonezilla-live/testing/";
$nchc['clonezilla-alternative-stable']      = "http://free.nchc.org.tw/clonezilla-live/alternative/stable/";
$nchc['clonezilla-alternative-testing']     = "http://free.nchc.org.tw/clonezilla-live/alternative/testing/";
$nchc['drbl-stable']                        = "http://free.nchc.org.tw/drbl-live/stable/";
$nchc['drbl-testing']                       = "http://free.nchc.org.tw/drbl-live/testing/";
#$nchc['drbl-unstable']                      = "http://free.nchc.org.tw/drbl-live/unstable/";
$nchc['gparted-stable']                     = "http://free.nchc.org.tw/gparted-live/stable/";
$nchc['gparted-testing']                    = "http://free.nchc.org.tw/gparted-live/testing/";
$nchc['freedos']		               = "http://free.nchc.org.tw/cloudboot/small_img/";
$nchc['memtest']		               = "http://free.nchc.org.tw/cloudboot/small_img/";
$nchc['memdisk']		               = "http://free.nchc.org.tw/cloudboot/small_img/";
$nchc['netinstall']		               = "http://free.nchc.org.tw/cloudboot/netinstall_img/";
$nchc['kernel']		               = "http://free.nchc.org.tw/cloudboot/kernel_img/";

### global variable for project download link from local mirror (you need mirror some files from sourceforge)
$local['clonezilla-stable']                 = "http://$local_url/$local_path/iso_img/";
$local['clonezilla-testing']                = "http://$local_url/$local_path/iso_img/";
$local['clonezilla-alternative-stable']     = "http://$local_url/$local_path/iso_img/";
$local['clonezilla-alternative-testing']    = "http://$local_url/$local_path/iso_img/";
$local['drbl-stable']                       = "http://$local_url/$local_path/iso_img/";
$local['drbl-testing']                      = "http://$local_url/$local_path/iso_img/";
#$local['drbl-unstable']                     = "http://$local_url/$local_path/iso_img/";
$local['gparted-stable']                    = "http://$local_url/$local_path/iso_img/";
$local['gparted-testing']                   = "http://$local_url/$local_path/iso_img/";
$local['freedos']			    = "http://$local_url/$local_path/small_img/";
$local['memtest']		            = "http://$local_url/$local_path/small_img/";
$local['memdisk']		            = "http://$local_url/$local_path/small_img/";
$local['netinstall']		            = "http://$local_url/$local_path/netinstall_img/";
$local['kernel']			    = "http://$local_url/$local_path/kernel_img/";

### global variable for project pattern which defined regular expression for iso link
$pattern['clonezilla-stable']              = '/<a href.*clonezilla.*iso.*>(.*)<\/a>/';
$pattern['clonezilla-testing']             = $pattern['clonezilla-stable'];
$pattern['clonezilla-alternative-stable']  = $pattern['clonezilla-stable'];
$pattern['clonezilla-alternative-testing'] = $pattern['clonezilla-stable'];
$pattern['drbl-stable']                    = '/<a href.*drbl.*iso.*>(.*)<\/a>/';
$pattern['drbl-testing']                   = $pattern['drbl-stable']; 
#$pattern['drbl-unstable']                  = $pattern['drbl-stable'];
$pattern['gparted-stable']                 = '/<a href.*gparted.*iso.*>(.*)<\/a>/';
$pattern['gparted-testing']                = $pattern['gparted-stable'];
$pattern['netinstall']			   = '/<a href.*initrd-netinstall-.*img.*>initrd-netinstall-(.*).img<\/a>/';

### menu layout
$menu['clonezilla']		= array('clonezilla-stable', 'clonezilla-testing');
$menu['clonezilla-alternative'] = array('clonezilla-alternative-stable', 'clonezilla-alternative-testing');
#$menu['drbl']			= array('drbl-stable', 'drbl-testing', 'drbl-unstable');
$menu['drbl']			= array('drbl-stable', 'drbl-testing');
$menu['gparted']		= array('gparted-stable', 'gparted-testing');
$menu['other']			= array('memtest','freedos','netinstall');
$all_menu = array_merge( $menu['clonezilla'], $menu['clonezilla-alternative'], $menu['drbl'], $menu['gparted'], $menu['other']);
?>
