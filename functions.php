<?php
### read conf/cloudboot.conffunction 
function read_option(){
   $conf = parse_ini_file( "conf/cloudboot.conf" );
   return $conf;
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

function KernelArchMenu ( $bootcfg, $repository ) {
    foreach ( $arch["$bootcfg"] ) {
	$kernel_uri	 = "$url[$repository]/$base_path[$repository]/$vmlinuz_file";
	$initrd_uri	 = "$url[$repository]/$base_path[$repository]/$initrd_file";
	$ipxe_net_config = "$ipxe_net";
	$filesystem	 = "$url[$repository]/$base_path[$repository]/$filesystem";
	$append_str	 = "initrd=$initrd_uri $filesystem ip=$ipxe_net_config $normal_config[$bootcfg]";
	label( $bootcfg );
	menu( $bootcfgi, $arch );
	kernel( $kernel_uri );
	append( $append_str );
    }
}

function ISOArchMenu ( $bootcfg, $repository ) {
    foreach ( $arch["$bootcfg"] ) {
	$kernel_uri = $memdisk_uri["$arch"];
	$append_str = "initrd=$initrd[$arch] iso raw";
	label( $bootcfg );
	menu( $bootcfg, $arch );
	kernel( $kernel_uri );
	append( $append_str );
    }
}
function KernelCloudMenu ( $bootcfg ) {
    foreach ( $repository ) {
	echo "MENU BEGIN $bootcfg CloudKernel from $repository\n";
	KernelArchMenu ( $bootcfg, $repository);
	echo "MENUEND\n";
    }
}

function ISOCloudMenu ( $bootcfg ) {
    foreach ( $repository ) {
	ISOArchMenu ( $bootcfg, $repository);
    }
}    

?>
