### TODO #######################################
# 1. SSL support?
# 2. change background.png
# 3. phram bug for bigger 512 memory in memdisk
################################################

##important######################################
# please set rewrite rule to web service like:	#
# BOOTMENU  => BOOTMENU.php			#
# boot.gpxe => boot.gpxe.php			#
#################################################


1. installation
## setup lighttp and php5-cgi
install php and lighttp
$ apt-get install lighttpd php5-cgi php5-common

### config php
configure and reset option in /etc/php5/cgi/php.ini
error_reporting = E_ALL & ~E_NOTICE
display_errors = Off

if you want debug, please set
error_reporting = E_ALL & ~E_DEPRECATED
display_errors = On

### config web server
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

2. prepare web applications
## source code
get cloudboot source code from git
git clone someone@free.nchc.org.tw:$port/home/gitpool/cloudboot/

## update ipxe
update rom-image.ipxe
chain http://yourserver/boot.gpxe
run script build-image and don't forget install build-essential and genisoimage
bash build-imag

## Netinstall
run script build-netinstall to get all netinstall image and don't forget install drbl

3. config
edit config.php

4. test and done
boot from ipxe.iso

