<?php

function get_iso_from_page($page, $regx){
    $proj_iso = array();
    if (preg_match_all($regx, $page, $match, PREG_SET_ORDER)){
	for ($i = 0; $i < sizeof($match); $i++){
	    array_push($proj_iso, $match[$i][1]);
	}
    } else {
	echo "can't find iso<br>\n";
    }
    return $proj_iso;
}

$url['clonezilla-stable']                  = "http://free.nchc.org.tw/clonezilla-live/stable/";
$url['clonezilla-testing']                 = "http://free.nchc.org.tw/clonezilla-live/testing/";
$url['clonezilla-alternative-stable']      = "http://free.nchc.org.tw/clonezilla-live/alternative/stable/";
$url['clonezilla-alternative-testing']     = "http://free.nchc.org.tw/clonezilla-live/alternative/testing/";
$url['drbl-stable']                        = "http://free.nchc.org.tw/drbl-live/stable/";
$url['drbl-testing']                       = "http://free.nchc.org.tw/drbl-live/testing/";
$url['drbl-unstable']                      = "http://free.nchc.org.tw/drbl-live/unstable/";
$url['gparted-stable']                     = "http://free.nchc.org.tw/gparted-live/stable/";
$url['gparted-testing']                    = "http://free.nchc.org.tw/gparted-live/testing/";

$pattern['clonezilla-stable']              = '/<a href.*clonezilla.*iso.*>(.*)<\/a>/';
$pattern['clonezilla-testing']             = $pattern['clonezilla-stable'];
$pattern['clonezilla-alternative-stable']  = $pattern['clonezilla-stable'];
$pattern['clonezilla-alternative-testing'] = $pattern['clonezilla-stable'];
$pattern['drbl-stable']                    = '/<a href.*drbl.*iso.*>(.*)<\/a>/';
$pattern['drbl-testing']                   = $pattern['drbl-stable']; 
$pattern['drbl-unstable']                  = $pattern['drbl-stable'];
$pattern['gparted-stable']                 = '/<a href.*gparted.*iso.*>(.*)<\/a>/';
$pattern['gparted-testing']                = $pattern['gparted-stable'];

foreach ($url as $proj => $link){
    $page = file_get_contents($url[$proj]);
    $iso = get_iso_from_page($page, $pattern[$proj]);
    foreach ($iso as $version) {
	echo $version."<br>\n";
    }
}


?>

