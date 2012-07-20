<?php
require "config.php";
$proj	= $_GET['proj'];
$type   = $_GET['type'];
$file   = $_GET['file'];
$mirror = $_GET['mirror'];
$rt = $_GET['rt'];

mapurl( $proj, $type, $file, $mirror, $rt );
?>
