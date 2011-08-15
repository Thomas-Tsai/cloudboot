#!/bin/bash
## edit config.php and enable sourceforge!!
## sync  boot.gpxe.php  BOOTMENU.php  config.php  get_image.php  guide.htm  pxe/  readme.txt VERSION to web.sourceforge.net /home/project-web/cloudboot/htdocs/
## and sync netinstall_img/ ipxe_image/ small_img/ to thomas_tsai,cloudboot@frs.sourceforge.net:/home/frs/project/c/cl/cloudboot/

source_path=`pwd`
sf_web_site="web.sourceforge.net"
sf_web_path="/home/project-web/cloudboot/htdocs/cloudboot/"
sf_file_site="frs.sourceforge.net"
sf_file_path="/home/frs/project/c/cl/cloudboot/"
project="cloudboot"
user="thomas_tsai"
files_for_web="boot.gpxe.php BOOTMENU.php config.php get_image.php guide.htm pxe readme.txt VERSION"
files_for_frs="netinstall_img ipxe_image small_img pxe iso_img kernel_img"
manual_sync_files=""


help()
{
    cat << EOF
	recognized flags are:
	--web       sync php file to cloudboot.sourceforge.net
	--frs	    sync image file to FRS
EOF
	exit 1
}

while [ ! -z "$1" ]
do
    case "$1" in
	--web)
	    web="y"
	;;
	--frs)
	    frs="y"
	;;
	--help)
	    help
	;;
	*)
	    manual_sync_files="$manual_sync_files $1"
	;;
    esac
    shift
done

for i in $manual_sync_files; do
    if [ ! -e $i ]; then
	echo "no this file : $i"
	exit
    fi
done


if [ "$frs" == "y" ]; then
    files_for_frs="$files_for_frs $manual_sync_files"
    for file in $files_for_frs;
    do
	frs_include_list="$frs_include_list --include=$file"
    done
    echo $frs_include_list
    rsync -avrl --delete-excluded -e ssh $frs_include_list --exclude=* $source_path/ $user,$project@$sf_file_site:$sf_file_path
fi

if [ "$web" == "y" ]; then
    files_for_web="$files_for_web $manual_sync_files"
    for file in $files_for_web;
    do
	web_include_list="$web_include_list --include=$file"
    done
    echo $web_include_list
    rsync -avrl --delete-excluded -e ssh $web_include_list --exclude=* $source_path/ $user@$sf_web_site:$sf_web_path
fi

echo "done"
