
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
$ lighttpd-enable-mod cgi

3. prepare web applications
## source code
#get cloudboot source code from git
cd /var/www
git clone someone@free.nchc.org.tw:$port/home/gitpool/cloudboot/


2. config
edit config.php

## update ipxe
run script build-image and don't forget install build-essential and genisoimage and syslinux and p7zip-full
bash build-image

## Netinstall
run script build-netinstall to get all netinstall image and don't forget install drbl

4. test and done
boot from ipxe.iso

## sync data
http://www.scriptol.com/how-to/upload-web-pages-to-sourceforge.php
