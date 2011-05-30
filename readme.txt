### TODO ##################
#1. SSL support?
#2. change background.png
###########################

##important###################################
# please set rewrite rule to web service like:
# BOOTMENU  => BOOTMENU.php
# boot.gpxe => boot.gpxe.php
##############################################


1. installation

install php and lighttp
$ apt-get install lighttpd php5-cgi php5-common

configure and set /etc/php5/cgi/php.ini
error_reporting = E_ALL & ~E_NOTICE
display_errors = Off

if you want debug, please set
error_reporting = E_ALL & ~E_DEPRECATED
display_errors = On

configure lighttpd.conf
$ ghttpd-enable-mod cgi
#set rewrite rule
server.modules = (
...
        "mod_rewrite",
)
.....
url.rewrite-once = (
    "drbloncloud/BOOTMENU"  => "$0.php",
    "drbloncloud/boot.gpxe"  => "$0.php" 
)

2.
get drbloncloud
run script build-image
bash build-imag

3. config url
vi config.php

4. done
