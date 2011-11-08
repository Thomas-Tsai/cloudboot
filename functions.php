<?php
### read conf/cloudboot.conffunction 
function read_option () {
   $conf = parse_ini_file( "conf/cloudboot.conf" );
   return $conf;
}

function repo_info ( $supported_repo ) {
    $conf = parse_ini_file( "conf/cloudboot.conf" );
    foreach ( $supported_repo as $name ) {
	eval( "\$urlp = \"repo_$name\".\"_url\";" );
	eval( "\$pathp = \"repo_$name\".\"_path\";" );
	eval( "\$pathisop = \"repo_$name\".\"_path_iso\";" );
	eval( "\$pathkernelp = \"repo_$name\".\"_path_kernel\";" );
	eval( "\$pathotherp = \"repo_$name\".\"_path_other\";" );
	eval( "\$pathnetinstallp = \"repo_$name\".\"_path_netinstall\";" );

	$url	    = $conf[$urlp];
	$path	    = $conf[$pathp];
	$pathiso    = $conf[$pathisop];
	$pathkernel = $conf[$pathkernelp];
	$pathother  = $conf[$pathotherp];
	$pathnetinstall  = $conf[$pathnetinstallp];

	$repo[$name]["url"]	= $url;
	$repo[$name]["path"]	= $path;
	$repo[$name]["iso"]	= $pathiso;
	$repo[$name]["kernel"]  = $pathkernel;
	$repo[$name]["other"]   = $pathother;
	$repo[$name]["netinstall"]   = $pathnetinstall;
    }
    return $repo;
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
function get_name_from_page($page, $regx){
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

    if ($page_ok){
	$iso = get_name_from_page($page, $pattern[$default_proj]);
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

function mapurl ( $proj, $type, $file, $mirror, $rt ) {
    global $supported_repo, $repo ,$$mirror;

    $fileurl="http://";
    if ( in_array ( $mirror, $supported_repo ) )
    {
	if ( $type == "iso" ) {
	    $url = $$mirror;
	    $fileurl = $url[$proj].$file;
	} else {
	    $imgurl = $repo[$mirror]["url"].'/'.$repo[$mirror]["path"].'/'.$repo[$mirror][$type].'/'.$file;
	    $imgurl = preg_replace("/\/\//", "/", $imgurl);
	    $fileurl = $fileurl.$imgurl;
	}
    }

    if ( $rt == 1 ) {
	//echo $fileurl;
	return $fileurl;
    } else {
	header( "Location: $fileurl");
    }
}

function ScanISO ( $bootcfg ) {
    global $nchc, $pattern, $prefix_name;
    $page = file_get_contents ( $nchc[$bootcfg] );
    $page_ok = preg_match ( "/200/", $http_response_header[0] );
    $prefix_name[$bootcfg] = array();
    if ( $page_ok ) {
	$iso = get_name_from_page ( $page, $pattern[$bootcfg] );
	$prefix = preg_replace ("/.iso/", "", $iso);
	foreach ( $prefix as $name ) {
	    array_push ($prefix_name[$bootcfg], $name);
	}
    }
    return $iso;

}

function ScanNetinstallImg ( $bootcfg ) {
    global $local, $pattern, $prefix_name;
    $page = file_get_contents ( $local[$bootcfg] );
    $page_ok = preg_match ( "/200/", $http_response_header[0] );
    $prefix_name[$bootcfg] = array();
    if ( $page_ok ) {
	$file = get_name_from_page ( $page, $pattern[$bootcfg] );
	$prefix = preg_replace ("/.img/", "", $file);
	foreach ( $prefix as $name ) {
	    array_push ($prefix_name[$bootcfg], $name);
	}
    }
    return $file;

}




function ScanKernel ( $bootcfg ) {
    global $prefix_name;
    if ( sizeof ( $prefix_name ) == 0 ) {
    	$iso = ScanISO ( $bootcfg );
    }
    return $prefix_name[$bootcfg];

}

function label ( $name ) {
    echo "label $name\n";
}

function menu ( $name, $desc ) {
    echo "menu label $name $desc\n";
}

function kernel ( $kernel ) {
    echo "kernel $kernel\n";
}

function append ( $append ) {
    echo "append $append\n";
}

function MemtestMenu ( $bootcfg, $repository ) {
    global $agent_url, $memtest;
    $name = "";

    $base_path	 = "http://$agent_url?mirror=$repository&type=other&proj=$bootcfg";
    $kernel	 = "$base_path&file=$memtest";
    label( $bootcfg );
    menu( $bootcfg, $name );
    kernel( $kernel );
}

function FreedosMenu ( $bootcfg, $repository ) {
    global $agent_url, $freedos, $repo, $memdisk_url;
    $name = "";

    $kernel_uri = 'http://'.$repo[$repository]["url"].'/'.$repo[$repository]["path"].$memdisk_url;
    $base_path	 = "http://$agent_url?mirror=$repository&type=other&proj=$bootcfg";
    $append_str	 = "initrd=$base_path&file=$freedos";
    label( $bootcfg );
    menu( $bootcfg, $name );
    kernel( $kernel_uri );
    append( $append_str );
   
}

function NetinstallMenu ( $bootcfg, $repository ) {
    global $agent_url, $memtest, $ramdisk;
    $name = "";

    $NetInstallImg = ScanNetinstallImg( $bootcfg );
    foreach ( $NetInstallImg as $img ) {
    $base_path	 = "http://$agent_url?mirror=$repository&type=netinstall&proj=$bootcfg";
    $kernel	 = "$base_path&file=vmlinuz-netinstall-$img";
    # replace vmlinux to initrd
    $append	 = "initrd=$base_path&file=initrd-netinstall-$img.img ramdisk=$ramdisk";
    label( $bootcfg );
    menu( $bootcfg, $name );
    kernel( $kernel );
    append( $append );
    }
}


function KernelArchMenu ( $bootcfg, $repository ) {
    global $kernel_param, $agent_url;
    #$ipxe_net = "eth0:140.110.240.46:255.255.255.0:140.110.240.254:8.8.8.8";
    #$ipxe_net = "dhcp"
    $kernel_prefix_name = ScanKernel( $bootcfg );
    foreach ( $kernel_prefix_name as $name) {
	$base_path	 = "http://$agent_url?mirror=$repository&type=kernel&proj=$bootcfg";
	$kernel		 = "$base_path&file=$name.vmlinuz";
	$initrd		 = "$base_path&file=$name.initrd.img";
	$filesystem	 = mapurl( $bootcfg, "kernel", $name, $repository, "1" ).".filesystem.squashfs";
	#$ipxe_net_config = $ipxe_net;
	#$append		 = "initrd=$initrd fetch=$filesystem ip=$ipxe_net_config $kernel_param[$bootcfg] ethdevice=eth2,eth3 ethdevice-timeout=1";
	$append		 = "initrd=$initrd fetch=$filesystem $kernel_param[$bootcfg]";
	label( $bootcfg );
	menu( $bootcfg, $name );
	kernel( $kernel );
	append( $append );
    }
}

function ISOArchMenu ( $bootcfg, $repository ) {
    global $repo, $memdisk_url, $agent_url;
    $iso = ScanISO( $bootcfg );
    foreach ( $iso as $iso_name ) {
	$kernel_uri = 'http://'.$repo[$repository]["url"].'/'.$repo[$repository]["path"].$memdisk_url;
	$iso_uri = "http://$agent_url?file=$iso_name&mirror=$repository&type=iso&proj=$bootcfg";
	$append_str = "initrd=$iso_uri iso raw";
	label( $bootcfg );
	menu( $bootcfg, $iso_name );
	kernel( $kernel_uri );
	append( $append_str );
	echo "\n";
    }
}

function memtest_menu ( $bootcfg ) {
    global $supported_repo;
    foreach ( $supported_repo as $repository ) {
	echo "MENU BEGIN $bootcfg Cloud from $repository\n";
	MemtestMenu ( $bootcfg, $repository);
	echo "MENU END\n";
    }
   
}

function freedos_menu ( $bootcfg ) {
    global $supported_repo;
    foreach ( $supported_repo as $repository ) {
	echo "MENU BEGIN $bootcfg Cloud from $repository\n";
	FreedosMenu ( $bootcfg, $repository);
	echo "MENU END\n";
    }

}

function netinstall_menu ( $bootcfg ) {
    global $supported_repo;
    foreach ( $supported_repo as $repository ) {
	echo "MENU BEGIN $bootcfg Cloud from $repository\n";
	NetinstallMenu ( $bootcfg, $repository);
	echo "MENU END\n";
    }

}

function KernelCloudMenu ( $bootcfg ) {
    global $supported_repo;
    foreach ( $supported_repo as $repository ) {
	echo "MENU BEGIN $bootcfg Cloud Kernel from $repository\n";
	KernelArchMenu ( $bootcfg, $repository);
	echo "MENU END\n";
    }
}

function ISOCloudMenu ( $bootcfg ) {
    global $supported_repo;
    foreach ( $supported_repo as $repository ) {
	echo "MENU BEGIN $bootcfg Cloud ISO from $repository\n";
	ISOArchMenu ( $bootcfg, $repository);
	echo "MENU END\n";
    }
}    

?>
