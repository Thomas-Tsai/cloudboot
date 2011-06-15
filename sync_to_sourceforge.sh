#!/bin/bash
## edit config.php and enable sourceforge!!
## sync  boot.gpxe.php  BOOTMENU.php  config.php  get_image.php  guide.htm  pxe/  readme.txt VERSION to web.sourceforge.net /home/project-web/cloudboot/htdocs/
## and sync netinstall_img/ ipxe_image/ small_img/ to thomas_tsai,cloudboot@frs.sourceforge.net:/home/frs/project/c/cl/cloudboot/

sf_web_site="web.sourceforge.net"
sf_web_path="/home/project-web/cloudboot/htdocs/"
sf_file_site="frs.sourceforge.net"
sf_file_path="/home/frs/project/c/cl/cloudboot/"
project="cloudboot"
user="thomas_tsai"
files_for_web="boot.gpxe.php BOOTMENU.php config.php get_image.php guide.htm pxe readme.txt VERSION test2.php phpinfo.php"
files_for_frs="netinstall_img ipxe_image small_img"

rsync -avrl --delete -e ssh $files_for_frs $user,$project@$sf_file_site:$sf_file_path/
rsync -avrl --delete -e ssh $files_for_web $user@$sf_web_site:$sf_web_path/
