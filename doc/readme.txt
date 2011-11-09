
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
# restart lighttpd
/etc/init.d/lighttpd restart

2. prepare web applications
## get source code
cd /var/www
lftp -c get http://cloudboot.nchc.org.tw/download/cloudboot-$version.tar.gz

## or get cloudboot source code from git
cd /var/www
git clone ssh://someone@free.nchc.org.tw:$port/home/gitpool/cloudboot/

3. config cloudboot
copy conf/cloudboot.conf.example conf/cloudboot.conf
edit conf/cloudboot.conf
***IMPORTANT*** update "repo_local_url" to your hostname.domainname

## update ipxe
## run script build-cloudboot-img and don't forget install build-essential and genisoimage and syslinux and p7zip-full 
## for Netinstall
## default enable netinstall is true, or edit conf/cloudboot.conf to update enable_netinstall = false
## enable netinstall img, don't forget install drbl
## add drbl repository
echo "deb http://free.nchc.org.tw/drbl-core drbl stable" >> /etc/apt/sources.list
wget -q http://drbl.nchc.org.tw/GPG-KEY-DRBL -O- | sudo apt-key add -
apt-get update
apt-get install build-essential genisoimage syslinux p7zip-full drbl
./INSTALL/build-cloudboot-img

##run sync tool, (rsync, lftp is needed)
##step1 get iso from free.nchc.org.tw (Taiwan)
##step2 extrace kernel, initrd.img and filesystem.squash
./INSTALL/prepare-live-img

4. test and done
boot from cloudboot.iso from cloudboot_img
