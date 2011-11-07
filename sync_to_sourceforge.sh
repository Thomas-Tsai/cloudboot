#!/bin/bash
## edit config.php and enable sourceforge!!
## sync  boot.gpxe.php  BOOTMENU.php  config.php  get_image.php  guide.htm  pxe/  readme.txt VERSION to web.sourceforge.net /home/project-web/cloudboot/htdocs/
## and sync netinstall_img/ ipxe_image/ small_img/ to thomas_tsai,cloudboot@frs.sourceforge.net:/home/frs/project/c/cl/cloudboot/

source_path=`pwd`
sf_file_site="frs.sourceforge.net"
sf_file_path="/home/frs/project/c/cl/cloudboot/"
project="cloudboot"
user="thomas_tsai"
files_for_frs="netinstall_img cloudboot_img small_img pxe iso_img kernel_img"
manual_sync_files=""


help()
{
    cat << EOF
	recognized flags are:
	--frs	    sync image file to FRS
EOF
	exit 1
}

while [ ! -z "$1" ]
do
    case "$1" in
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
	rsync -avrlP --delete -e ssh $file $user,$project@$sf_file_site:$sf_file_path
    done
fi

echo "done"
