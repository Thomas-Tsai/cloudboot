
1. Installation
## setup lighttp and php5-cgi
install php and lighttp
$ apt-get install lighttpd php5-cgi php5-common

## config php
configure and reset option in /etc/php5/cgi/php.ini
error_reporting = E_ALL & ~E_NOTICE
display_errors = Off

if you want debug, please set
error_reporting = E_ALL & ~E_DEPRECATED
display_errors = On

## config web server
configure lighttpd.conf
$ lighttpd-enable-mod cgi

and edit /etc/lighttpd/conf-enabled/10-cgi.conf

## Warning this represents a security risk, as it allow to execute any file
## with a .pl/.py even outside of /usr/lib/cgi-bin.
#
cgi.assign      = (
#   ".pl"  => "/usr/bin/perl",
#   ".py"  => "/usr/bin/python",
    ".php" => "/usr/bin/php-cgi",
    )

2. prepare web applications
## get cloudboot source code from git
cd /var/www
git clone ssh://someone@free.nchc.org.tw:$port/home/gitpool/cloudboot/


3. config cloudboot
edit conf/cloudboot.conf

## update ipxe
## run script build-image and don't forget install build-essential and genisoimage and syslinux and p7zip-full
apt-get install build-essential and genisoimage and syslinux p7zip-full
./build-image

##run sync tool, step1 get iso from free.nchc.org.tw, step2 extrace kernel, initrd.img and filesystem.squash
./prepare_form_free.sh

## Netinstall
## run script build-netinstall to get all netinstall image and don't forget install drbl
./build-netinstall

4. test and done
boot from cloudboot.iso from ipxe_image
